<?php

namespace SudoBee\Cygnus\Tests\Unit\Component;

use SudoBee\Cygnus\Component\Component;
use SudoBee\Cygnus\Core\Utilities\ExportBuilder;

class TestComponent extends Component
{
	public function export(): array
	{
		return ExportBuilder::make($this)->export();
	}
}
