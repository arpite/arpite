<?php

namespace Arpite\Component\Components\Button;

use Arpite\Component\ButtonTemplate;
use Arpite\Component\Traits\HasButtonDesign;
use Arpite\Component\Traits\HasDisabled;
use Arpite\Component\Traits\HasIcon;
use Arpite\Core\Utilities\ExportBuilder;

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
