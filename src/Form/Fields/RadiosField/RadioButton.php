<?php

namespace SudoBee\Cygnus\Form\Fields\RadiosField;

use SudoBee\Cygnus\Component\Component;
use SudoBee\Cygnus\Component\Traits\HasDescription;
use SudoBee\Cygnus\Component\Traits\HasTitle;
use SudoBee\Cygnus\Core\Utilities\ExportBuilder;

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
