<?php

namespace SudoBee\Cygnus\Form\Fields\Traits;

use SudoBee\Cygnus\Core\Utilities\ExportBuilder;

trait HasMinAndMax
{
	private ?int $min = null;

	private ?int $max = null;

	/**
	 * @param int|null $min
	 * @return static
	 */
	public function setMin(?int $min)
	{
		$this->min = $min;

		if ($this->min === null) {
			$this->removeValidationRule("min");
		} else {
			$this->addValidationRule("min:$min");
		}

		return $this;
	}

	/**
	 * @param int|null $max
	 * @return static
	 */
	public function setMax(?int $max)
	{
		$this->max = $max;

		if ($this->max === null) {
			$this->removeValidationRule("max");
		} else {
			$this->addValidationRule("max:$max");
		}

		return $this;
	}

	/**
	 * @return mixed[]
	 */
	private function minAndMaxExport(): array
	{
		return ExportBuilder::make()
			->addProperty("min", $this->min)
			->addProperty("max", $this->max)
			->export();
	}
}
