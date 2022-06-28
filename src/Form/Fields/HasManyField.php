<?php

namespace Arpite\Arpite\Form\Fields;

use Arpite\Arpite\Component\Component;
use Arpite\Arpite\Core\Utilities\ExportBuilder;
use Arpite\Arpite\Form\Actions\GetNestedFieldsAction;
use Arpite\Arpite\Form\Actions\GetNestedFieldsDefaultValuesAction;
use Arpite\Arpite\Form\Fields\Classes\Dependee;
use Exception;
use Illuminate\Support\Collection;

/**
 * @extends Field<Collection<Component>|array<int, Component>>
 */
class HasManyField extends Field
{
	/** @var Collection<int, Component> $unparsedDefaultValue */
	private Collection $unparsedDefaultValue;

	private string $addButtonText = "Add new";

	/**
	 * @var Component[] $template
	 */
	private array $template = [];

	private function __construct(string $label, ?string $name = null)
	{
		parent::__construct($label, $name);

		$this->setDefaultValue([]);

		$this->setOptional();
		$this->addValidationRule("array");
	}

	public static function make(string $label, ?string $name = null): self
	{
		return new self($label, $name);
	}

	/**
	 * @param Component[] $nodes
	 * @return static
	 */
	public function setTemplate(array $nodes)
	{
		$this->template = $nodes;
		$this->updateDefaultValue();

		return $this;
	}

	/**
	 * @param string $addButtonText
	 * @return static
	 */
	public function setAddButtonText(string $addButtonText)
	{
		$this->addButtonText = $addButtonText;

		return $this;
	}

	/**
	 * @param Collection<int, Component>|array<int, Component> $defaultValue
	 * @return static
	 */
	public function setDefaultValue($defaultValue)
	{
		$this->unparsedDefaultValue = is_array($defaultValue)
			? collect($defaultValue)
			: $defaultValue;
		$this->updateDefaultValue();

		return $this;
	}

	public function getValidationRules(object $formValues): array
	{
		$rules = parent::getValidationRules($formValues);

		$fields = $this->getFields();
		$itemValidationRules = array_reduce(
			$fields,
			function ($previous, Field $field) use ($formValues) {
				$fieldsRules = $field->getValidationRules($formValues);

				$newName = $this->getName() . ".*." . $field->getName();
				$previous[$newName] = $fieldsRules[$field->getName()];

				return $previous;
			},
			[]
		);

		return array_merge($rules, $itemValidationRules);
	}

	/**
	 * @throws Exception
	 * @return static
	 */
	public function addDependee(Dependee $dependee)
	{
		throw new Exception(
			"Dependees are not implemented for HasManyField yet."
		);
	}

	/**
	 * @throws Exception
	 * @param Dependee[] $dependees
	 * @return static
	 */
	public function addDependees(array $dependees)
	{
		throw new Exception(
			"Dependees are not implemented for HasManyField yet."
		);
	}

	/**
	 * Parses unparsed default value and sets
	 * that value to field's default value
	 */
	private function updateDefaultValue(): void
	{
		$fields = $this->getFields();

		if (count($fields) === 0) {
			parent::setDefaultValue([]);
			return;
		}

		$parsedDefaultValue = $this->unparsedDefaultValue->map(
			fn($unparsedItemValues) => array_reduce(
				$fields,
				function ($previous, Field $field) use ($unparsedItemValues) {
					$name = $field->getName();

					if (
						/** @phpstan-ignore-next-line  */
						is_array($unparsedItemValues) &&
						/** @phpstan-ignore-next-line  */
						isset($unparsedItemValues[$name])
					) {
						$previous[$name] = $unparsedItemValues[$name];
					} elseif (
						is_object($unparsedItemValues) &&
						isset($unparsedItemValues->$name)
					) {
						$previous[$name] = $unparsedItemValues->$name;
					} else {
						throw new Exception(
							'Value was not found for field "' .
								$name .
								'" in given default value.'
						);
					}

					return $previous;
				},
				[]
			)
		);

		parent::setDefaultValue($parsedDefaultValue->toArray());
	}

	/**
	 * @return array<mixed>
	 */
	private function getTemplateDefaultValue(): array
	{
		return app(GetNestedFieldsDefaultValuesAction::class)->execute(
			$this->template,
			(object) [] // TODO: rework form default values and dependers. for now by passing [], dependers in has-many might not work properly
		);
	}

	/**
	 * @return Field<mixed>[]
	 */
	private function getFields(): array
	{
		return app(GetNestedFieldsAction::class)->execute($this->template);
	}

	/**
	 * @return array<mixed>
	 */
	public function export(): array
	{
		$templateDefaultValue = $this->getTemplateDefaultValue();

		return ExportBuilder::make($this)
			->mergeProperties($this->fieldExport())
			->addProperty("addButtonText", $this->addButtonText)
			->addNodesProperty("template", $this->template)
			->addProperty("templateDefaultValue", $templateDefaultValue)
			->export();
	}
}
