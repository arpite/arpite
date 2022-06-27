<?php

namespace SudoBee\Cygnus\Form\Fields;

use SudoBee\Cygnus\Core\Utilities\ExportBuilder;
use SudoBee\Cygnus\Form\Fields\Traits\HasMinAndMax;

/**
 * @extends Field<?int>
 */
class NumberField extends Field
{
	use HasMinAndMax;

	private ?string $suffix = null;

	private int $decimalScale = 2;

	private function __construct(string $label, ?string $name = null)
	{
		parent::__construct($label, $name);

		$this->setDefaultValue(null);

		$this->addValidationRule("numeric");

		$this->addValidationRule("integer");

		$this->setMin(0);
	}

	public static function make(string $label, ?string $name = null): self
	{
		return new self($label, $name);
	}

	public function setSuffix(?string $suffix): self
	{
		$this->suffix = $suffix;

		return $this;
	}

	public function setDecimalScale(int $decimalScale): self
	{
		$this->decimalScale = $decimalScale;

		return $this;
	}

	public function presetMoney(): self
	{
		$this->setSuffix(" EUR")
			->setDecimalScale(2)
			->setPlaceholder("0.00 EUR")
			->setMin(0)
			->setMax(null);

		return $this;
	}

	public function presetWeight(): self
	{
		$this->setSuffix(" g")
			->setDecimalScale(0)
			->setPlaceholder("0 g")
			->setMin(0)
			->setMax(null);

		return $this;
	}

	public function presetDimension(): self
	{
		$this->setSuffix(" cm")
			->setDecimalScale(1)
			->setPlaceholder("0.0 cm")
			->setMin(0)
			->setMax(null);

		return $this;
	}

	/**
	 * @return mixed[]
	 */
	public function export(): array
	{
		return ExportBuilder::make($this)
			->mergeProperties($this->fieldExport())
			->mergeProperties($this->minAndMaxExport())
			->addProperty("suffix", $this->suffix)
			->addProperty("decimalScale", $this->decimalScale)
			->export();
	}
}
