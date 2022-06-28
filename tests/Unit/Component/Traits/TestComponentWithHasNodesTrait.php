<?php

namespace Arpite\Arpite\Tests\Unit\Component\Traits;

use Arpite\Arpite\Component\Component;
use Arpite\Arpite\Component\Traits\HasNodes;
use Arpite\Arpite\Core\Utilities\ExportBuilder;

class TestComponentWithHasNodesTrait extends Component
{
	use HasNodes;

	public function export(): array
	{
		return ExportBuilder::make($this)
			->mergeProperties($this->nodesExport())
			->export();
	}
}
