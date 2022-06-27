<?php

namespace SudoBee\Cygnus\Tests\Unit\Component\Traits\HasButtonColor;

use SudoBee\Cygnus\Component\Component;
use SudoBee\Cygnus\Component\Traits\HasButtonColor;
use SudoBee\Cygnus\Core\Utilities\ExportBuilder;

class TestComponentWithHasButtonColorTrait extends Component
{
	use HasButtonColor;

	public function export(): array
	{
		return ExportBuilder::make($this)
			->mergeProperties($this->buttonColorExport())
			->export();
	}
}
