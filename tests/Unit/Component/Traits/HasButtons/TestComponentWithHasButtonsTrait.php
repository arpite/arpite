<?php

namespace SudoBee\Cygnus\Tests\Unit\Component\Traits\HasButtons;

use SudoBee\Cygnus\Component\Component;
use SudoBee\Cygnus\Component\Traits\HasButtons;
use SudoBee\Cygnus\Core\Utilities\ExportBuilder;

class TestComponentWithHasButtonsTrait extends Component
{
	use HasButtons;

	public function export(): array
	{
		return ExportBuilder::make($this)
			->mergeProperties($this->buttonsExport())
			->export();
	}
}
