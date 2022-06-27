<?php

namespace SudoBee\Cygnus\Tests\Unit\Component\Traits;

use SudoBee\Cygnus\Component\Component;
use SudoBee\Cygnus\Component\Traits\HasGap;
use SudoBee\Cygnus\Core\Utilities\ExportBuilder;

class TestComponentWithHasGapTrait extends Component
{
	use HasGap;

	public function export(): array
	{
		return ExportBuilder::make($this)
			->mergeProperties($this->gapExport())
			->export();
	}
}
