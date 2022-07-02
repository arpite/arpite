<?php

namespace Arpite\Form\Fields;

use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Arpite\Component\Component;
use Arpite\Component\Components\Text;
use Arpite\Component\Rules\DeepEqualRule;
use Arpite\Component\Traits\HasDisabled;
use Arpite\ResourceFieldConfiguration\Traits\HasResourceConfigurations;
use Arpite\Core\Utilities\ExportBuilder;
use Arpite\Form\Fields\Classes\Dependee;

/**
 * @template TDefaultValue
 */
abstract class Field extends Component
{
	use HasDisabled, HasResourceConfigurations;

	private string $name;

	private string|Text $label;

	private ?string $placeholder = null;

	private ?string $explanation = null;

	/** @var mixed $defaultValue */
	private mixed $defaultValue = null;

	/** @var Collection<int, mixed> */
	private Collection $validationRules;

	/** @var Collection<int, Dependee> $dependees */
	private Collection $dependees;

	/**
	 * @throws Exception
	 */
	public function __construct(string|Text $label, ?string $name = null)
	{
		if ($name === null && $label instanceof Text) {
			throw new Exception(
				"When component Text is used for field label, the name must be provided."
			);
		}

		$this->bootHasResourceConfigurations();

		$this->label = $label;

		$this->name = $name === null ? Str::snake($label) : $name;

		$this->validationRules = collect(["required"]);

		/** @phpstan-ignore-next-line  */
		$this->dependees = collect([]);
	}

	/**
	 * @return static
	 */
	public function setOptional(bool $optional = true)
	{
		if ($optional) {
			$this->removeValidationRule("required");

			$this->addValidationRule("nullable");
		} else {
			$this->addValidationRule("required");

			$this->removeValidationRule("nullable");
		}

		return $this;
	}

	/**
	 * @param string|null $explanation
	 * @return static
	 */
	public function setExplanation(?string $explanation)
	{
		$this->explanation = $explanation;

		return $this;
	}

	/**
	 * @param string|null $placeholder
	 * @return static
	 */
	public function setPlaceholder(?string $placeholder)
	{
		$this->placeholder = $placeholder;

		return $this;
	}

	/**
	 * @param TDefaultValue $defaultValue
	 * @return static
	 */
	public function setDefaultValue($defaultValue): static
	{
		$this->defaultValue = $defaultValue;

		return $this;
	}

	/**
	 * @param object|string $rule
	 * @return static
	 */
	public function addValidationRule(object|string $rule)
	{
		if (!$this->validationRules->contains($rule)) {
			$this->validationRules->push($rule);
		}

		return $this;
	}

	/**
	 * @param string $ruleName
	 * @return static
	 */
	public function removeValidationRule(string $ruleName)
	{
		$this->validationRules = $this->validationRules->filter(function (
			$rule
		) use ($ruleName) {
			if (is_object($rule)) {
				return $ruleName !== class_basename($rule);
			}

			return $ruleName !== $rule &&
				!Str::startsWith($rule, $ruleName . ":");
		});

		return $this;
	}

	/**
	 * @param object $formValues
	 * @return array<string, mixed>
	 */
	public function getValidationRules(object $formValues): array
	{
		$fieldValue = $formValues->{$this->name} ?? $this->defaultValue;

		/**
		 * We allow only default value to be submitted
		 * when field is disabled
		 */
		$fieldRules = $this->disabled
			? [new DeepEqualRule($fieldValue)]
			: $this->validationRules->all();

		$activeDependeesValidationsRules = $this->getActiveDependees(
			$fieldValue
		)->reduce(
			fn(array $previous, Dependee $dependee) => array_merge(
				$previous,
				$dependee->getFieldsValidationRules($formValues)
			),
			[]
		);

		return array_merge(
			[$this->name => $fieldRules],
			$activeDependeesValidationsRules
		);
	}

	public function getLabel(): string|Text
	{
		return $this->label;
	}

	public function getName(): string
	{
		return $this->name;
	}

	/**
	 * @param object $formValues
	 * @return array<string, mixed>
	 */
	public function getDefaultValue(object $formValues): array
	{
		$defaultValue = $formValues->{$this->name} ?? $this->defaultValue;

		$activeDependeesDefaultValues = $this->getActiveDependees(
			$defaultValue
		)->reduce(
			fn(array $previous, Dependee $dependee) => array_merge(
				$previous,
				$dependee->getFieldsDefaultValues()
			),
			[]
		);

		return array_merge(
			[$this->name => $this->defaultValue],
			$activeDependeesDefaultValues
		);
	}

	/**
	 * @param Dependee $dependee
	 * @return static
	 */
	public function addDependee(Dependee $dependee)
	{
		$this->dependees->add($dependee);

		return $this;
	}

	/**
	 * @param Dependee[] $dependees
	 * @return static
	 */
	public function addDependees(array $dependees)
	{
		$this->dependees = $this->dependees->merge($dependees);

		return $this;
	}

	protected function isRequired(): bool
	{
		return $this->validationRules->contains("required");
	}

	/**
	 * @param mixed $fieldValue
	 * @return Collection<int, Dependee>
	 */
	private function getActiveDependees(mixed $fieldValue): Collection
	{
		return $this->dependees->filter(
			fn(Dependee $dependee) => $dependee->isActive($fieldValue)
		);
	}

	/**
	 * @return array<string, mixed>
	 */
	protected function fieldExport(): array
	{
		return ExportBuilder::make()
			->mergeProperties($this->disabledExport())
			->addProperty("name", $this->name)
			->addProperty(
				"label",
				$this->label instanceof Text ? $this->label : __($this->label)
			)
			->addProperty("defaultValue", $this->defaultValue)
			->addProperty("explanation", $this->explanation)
			->addProperty("placeholder", $this->placeholder)
			->addProperty("required", $this->isRequired())
			->addNodesProperty("dependees", $this->dependees->all())
			->export();
	}
}
