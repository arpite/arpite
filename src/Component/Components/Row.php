<?php

namespace SudoBee\Cygnus\Component\Components;

use SudoBee\Cygnus\Component\Component;
use SudoBee\Cygnus\Component\Traits\HasGap;
use SudoBee\Cygnus\Component\Traits\HasNodes;
use SudoBee\Cygnus\Core\Utilities\ExportBuilder;

class Row extends Component
{
	use HasNodes;
	use HasGap;

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
			->mergeProperties($this->nodesExport())
			->mergeProperties($this->gapExport())
			->export();
	}
}
