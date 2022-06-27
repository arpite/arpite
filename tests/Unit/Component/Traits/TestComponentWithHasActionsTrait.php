<?php

namespace SudoBee\Cygnus\Tests\Unit\Component\Traits;

use SudoBee\Cygnus\Component\Component;
use SudoBee\Cygnus\Component\Traits\HasActions;
use SudoBee\Cygnus\Core\Utilities\ExportBuilder;

class TestComponentWithHasActionsTrait extends Component
{
	use HasActions;

	public function export(): array
	{
		return ExportBuilder::make($this)
			->mergeProperties($this->actionsExport())
			->export();
	}
}
