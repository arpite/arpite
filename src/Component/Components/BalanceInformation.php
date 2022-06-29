<?php

namespace Arpite\Component\Components;

use Arpite\Component\Component;
use Arpite\Component\Traits\HasActions;
use Arpite\Component\Traits\HasTitle;
use Arpite\Core\Utilities\ExportBuilder;

class BalanceInformation extends Component
{
	use HasTitle;
	use HasActions;

	public static function make(): self
	{
		return new self();
	}

	/**
	 * @return array<mixed>
	 */
	public function export(): array
	{
		return ExportBuilder::make($this)
			->mergeProperties($this->titleExport())
			->mergeProperties($this->actionsExport())
			->export();
	}
}
