<?php

namespace SudoBee\Cygnus\Tests\Unit\Component\Traits;

use SudoBee\Cygnus\Component\Component;
use SudoBee\Cygnus\Component\Traits\HasDisabled;
use SudoBee\Cygnus\Core\Utilities\ExportBuilder;

class TestComponentWithHasDisabledTrait extends Component
{
	use HasDisabled;

	public function export(): array
	{
		return ExportBuilder::make($this)
			->mergeProperties($this->disabledExport())
			->export();
	}
}
