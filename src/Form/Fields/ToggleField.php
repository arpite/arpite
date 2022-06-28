<?php

namespace Arpite\Arpite\Form\Fields;

use Arpite\Arpite\Component\Traits\HasDescription;
use Arpite\Arpite\Core\Utilities\ExportBuilder;
use Illuminate\Validation\Rule;

/**
 * @extends Field<boolean>
 */
class ToggleField extends Field
{
	use HasDescription;

	private function __construct(string $label, ?string $name = null)
	{
		parent::__construct($label, $name);

		$this->setDefaultValue(false);

		$this->addValidationRule(Rule::in([true, false]));
	}

	public static function make(string $label, ?string $name = null): self
	{
		return new self($label, $name);
	}

	/**
	 * @return mixed[]
	 */
	public function export(): array
	{
		return ExportBuilder::make($this)
			->mergeProperties($this->fieldExport())
			->mergeProperties($this->descriptionExport())
			->export();
	}
}
