<?php

namespace SudoBee\Cygnus\Component\Components\Table\Cells;

use SudoBee\Cygnus\Component\Component;
use SudoBee\Cygnus\Component\Traits\HasNodes;
use SudoBee\Cygnus\Core\Utilities\ExportBuilder;

class TableLinks extends Component
{
	use HasNodes;

	public static function make(): self
	{
		return new self();
	}

	/**
	 * @return array<string, mixed>
	 */
	public function export(): array
	{
		return ExportBuilder::make($this)
			->mergeProperties($this->nodesExport())
			->export();
	}
}
