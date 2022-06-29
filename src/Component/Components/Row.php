<?php

namespace Arpite\Component\Components;

use Arpite\Component\Component;
use Arpite\Component\Traits\HasGap;
use Arpite\Component\Traits\HasNodes;
use Arpite\Core\Utilities\ExportBuilder;

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
