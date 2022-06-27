<?php

namespace SudoBee\Cygnus\Tests\Unit\Component\Traits\HasIcon;

use SudoBee\Cygnus\Component\Component;
use SudoBee\Cygnus\Component\Traits\HasIcon;
use SudoBee\Cygnus\Core\Utilities\ExportBuilder;

class TestComponentWithHasIconTrait extends Component
{
	use HasIcon;

	public function export(): array
	{
		return ExportBuilder::make($this)
			->mergeProperties($this->iconExport())
			->export();
	}
}
