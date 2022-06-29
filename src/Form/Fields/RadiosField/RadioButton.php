<?php

namespace Arpite\Form\Fields\RadiosField;

use Arpite\Component\Component;
use Arpite\Component\Traits\HasDescription;
use Arpite\Component\Traits\HasTitle;
use Arpite\Core\Utilities\ExportBuilder;

class RadioButton extends Component
{
	use HasTitle;
	use HasDescription;

	private float|bool|int|string $value;

	private function __construct(float|bool|int|string $value)
	{
		$this->value = $value;
	}

	public static function make(float|bool|int|string $value): self
	{
		return new self($value);
	}

	public function getValue(): float|bool|int|string
	{
		return $this->value;
	}

	/**
	 * @return array<string, mixed>
	 */
	public function export(): array
	{
		return ExportBuilder::make($this)
			->mergeProperties($this->titleExport())
			->mergeProperties($this->descriptionExport())
			->addProperty("value", $this->value)
			->export();
	}
}
