<?php

namespace SudoBee\Cygnus\Tests\Unit\Component\Traits;

use SudoBee\Cygnus\Component\Component;
use SudoBee\Cygnus\Component\Traits\HasAction;
use SudoBee\Cygnus\Core\Utilities\ExportBuilder;

class TestComponentWithHasActionTrait extends Component
{
	use HasAction;

	public function export(): array
	{
		return ExportBuilder::make($this)
			->mergeProperties($this->actionExport())
			->export();
	}
}
