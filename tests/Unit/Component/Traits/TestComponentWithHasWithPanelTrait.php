<?php

namespace SudoBee\Cygnus\Tests\Unit\Component\Traits;

use SudoBee\Cygnus\Component\Component;
use SudoBee\Cygnus\Component\Traits\HasWithPanel;
use SudoBee\Cygnus\Core\Utilities\ExportBuilder;

class TestComponentWithHasWithPanelTrait extends Component
{
	use HasWithPanel;

	public function export(): array
	{
		return ExportBuilder::make($this)
			->mergeProperties($this->withPanelExport())
			->export();
	}
}
