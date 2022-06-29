<?php

namespace Arpite\Tests\Unit\Component\Traits;

use Arpite\Component\Component;
use Arpite\Component\Traits\HasNodes;
use Arpite\Core\Utilities\ExportBuilder;

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
