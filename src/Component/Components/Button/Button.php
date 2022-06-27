<?php

namespace SudoBee\Cygnus\Component\Components\Button;

use SudoBee\Cygnus\Component\ButtonTemplate;
use SudoBee\Cygnus\Component\Traits\HasButtonDesign;
use SudoBee\Cygnus\Component\Traits\HasDisabled;
use SudoBee\Cygnus\Component\Traits\HasIcon;
use SudoBee\Cygnus\Core\Utilities\ExportBuilder;

class Button extends ButtonTemplate
{
	use HasDisabled;
	use HasButtonDesign;
	use HasIcon;

	private bool $fullWidth = false;

	public static function make(): self
	{
		return new self();
	}

	/**
	 * @param bool $fullWidth
	 * @return static
	 */
	public function setFullWidth(bool $fullWidth = true)
	{
		$this->fullWidth = $fullWidth;

		return $this;
	}

	/**
	 * @return array<string, mixed>
	 */
	public function export(): array
	{
		return ExportBuilder::make($this)
			->mergeProperties($this->buttonTemplateExport())
			->mergeProperties($this->disabledExport())
			->mergeProperties($this->iconExport())
			->addProperty("design", $this->design)
			->addProperty("fullWidth", $this->fullWidth)
			->export();
	}
}
