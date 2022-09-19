<?php

namespace Arpite\Form\Fields;

use Arpite\Component\Rules\ArrayItemsDistinctRule;
use Arpite\Core\Utilities\ExportBuilder;
use Exception;
use Illuminate\Validation\Rule;

/**
 * @extends Field<mixed>
 */
class SelectField extends Field
{
	/** @var array{label: string, value: mixed, image?: string}[] $options */
	private array $options = [];

	private bool $searchable = false;

	private bool $multiple = false;

	private mixed $providedDefaultValue;

	private function __construct(string $label, ?string $name = null)
	{
		parent::__construct($label, $name);

		$this->setDefaultValue(null);

		$this->reapplyValidationRules();
	}

	public static function make(string $label, ?string $name = null): self
	{
		return new self($label, $name);
	}

	public function setSearchable(bool $searchable = true): static
	{
		$this->searchable = $searchable;

		return $this;
	}

	public function setMultiple(bool $multiple = true): static
	{
		$this->multiple = $multiple;
		$this->updateDefaultValue();
		$this->reapplyValidationRules();

		return $this;
	}

	/**
	 * @param array<int, array{label: string, value: mixed, image?: string}> $options
	 * @return static
	 */
	public function setOptions(array $options): static
	{
		$this->options = $options;
		$this->updateDefaultValue();
		$this->reapplyValidationRules();

		return $this;
	}

	/**
	 * @param mixed $defaultValue
	 * @return static
	 */
	public function setDefaultValue($defaultValue): static
	{
		/**
		 * We store developer provided default value to a
		 * different property, so that when multiple selection
		 * is toggled, we would set the correct default value
		 * and so that we would not overwrite default value that
		 * was provided by developer.
		 */
		$this->providedDefaultValue = $defaultValue;

		$this->updateDefaultValue();

		return $this;
	}

	private function updateDefaultValue(): void
	{
		/**
		 * We check if developer have provided us with
		 * a default value. If yes - we set that value as
		 * default, if not - we set the default value
		 * according to multiple selection setting.
		 */
		if (isset($this->providedDefaultValue)) {
			parent::setDefaultValue($this->providedDefaultValue);
			return;
		}

		if ($this->multiple) {
			parent::setDefaultValue([]);
		} else {
			parent::setDefaultValue(null);
		}
	}

	private function reapplyValidationRules(): void
	{
		if ($this->multiple) {
			$this->addValidationRule("array");
			$this->addValidationRule(new ArrayItemsDistinctRule());
		} else {
			$this->removeValidationRule("array");
			$this->removeValidationRule(new ArrayItemsDistinctRule());
		}

		$this->addValidationRule(
			Rule::in(collect($this->options)->pluck("value"))
		);
	}

	/**
	 * @return array<string, mixed>
	 * @throws Exception
	 */
	public function export(): array
	{
		if ($this->multiple && !is_array($this->defaultValue)) {
			throw new Exception(
				"SelectField default value must be array when multiple selection is enabled."
			);
		}
		if (!$this->multiple && is_array($this->defaultValue)) {
			throw new Exception(
				"SelectField default value must not be array when multiple selection is not enabled."
			);
		}

		return ExportBuilder::make($this)
			->mergeProperties($this->fieldExport())
			->addProperty("options", $this->options)
			->addProperty("searchable", $this->searchable)
			->addProperty("multiple", $this->multiple)
			->export();
	}
}
