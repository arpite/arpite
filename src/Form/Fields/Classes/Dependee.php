<?php

namespace SudoBee\Cygnus\Form\Fields\Classes;

use SudoBee\Cygnus\Component\Traits\HasNodes;
use SudoBee\Cygnus\Core\Interfaces\Exportable;
use SudoBee\Cygnus\Core\Utilities\ExportBuilder;
use SudoBee\Cygnus\Form\Actions\GetNestedFieldsDefaultValuesAction;
use SudoBee\Cygnus\Form\Actions\GetNestedFieldsValidationRulesAction;

class Dependee implements Exportable
{
	use HasNodes;

	private function __construct(private mixed $value)
	{
	}

	public static function make(mixed $value): self
	{
		return new self(value: $value);
	}

	public function setValue(mixed $value): self
	{
		$this->value = $value;

		return $this;
	}

	public function isActive(mixed $fieldValue): bool
	{
		return $this->value === $fieldValue;
	}

	/**
	 * @return array<string, mixed>
	 */
	public function getFieldsDefaultValues(): array
	{
		return app(GetNestedFieldsDefaultValuesAction::class)->execute(
			$this->getNodes(),
			(object) [] // TODO: rework form default values and dependers. for now by passing [], we will not support nested dependers
		);
	}

	/**
	 * @param object $formValues
	 * @return array<string, mixed>
	 */
	public function getFieldsValidationRules(object $formValues): array
	{
		return app(GetNestedFieldsValidationRulesAction::class)->execute(
			$this->getNodes(),
			$formValues
		);
	}

	public function export(): array
	{
		$fieldsDefaultValues = $this->getFieldsDefaultValues();

		return ExportBuilder::make()
			->mergeProperties($this->nodesExport())
			->addProperty("value", $this->value)
			->addProperty("fieldsDefaultValues", $fieldsDefaultValues)
			->export();
	}
}
