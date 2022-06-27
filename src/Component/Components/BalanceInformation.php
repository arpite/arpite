<?php

namespace SudoBee\Cygnus\Component\Components;

use SudoBee\Cygnus\Component\Component;
use SudoBee\Cygnus\Component\Traits\HasActions;
use SudoBee\Cygnus\Component\Traits\HasTitle;
use SudoBee\Cygnus\Core\Utilities\ExportBuilder;

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
