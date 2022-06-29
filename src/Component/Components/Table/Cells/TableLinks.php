<?php

namespace Arpite\Component\Components\Table\Cells;

use Arpite\Component\Component;
use Arpite\Component\Traits\HasNodes;
use Arpite\Core\Utilities\ExportBuilder;

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
