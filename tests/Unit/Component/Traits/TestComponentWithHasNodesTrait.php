<?php

namespace SudoBee\Cygnus\Tests\Unit\Component\Traits;

use SudoBee\Cygnus\Component\Component;
use SudoBee\Cygnus\Component\Traits\HasNodes;
use SudoBee\Cygnus\Core\Utilities\ExportBuilder;

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
