<?php

namespace Arpite\Arpite\Component\Components;

use Arpite\Arpite\Component\Component;
use Arpite\Arpite\Component\Traits\HasGap;
use Arpite\Arpite\Component\Traits\HasNodes;
use Arpite\Arpite\Core\Utilities\ExportBuilder;

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
