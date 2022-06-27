<?php

namespace SudoBee\Cygnus\Tests\Unit\Component\Traits\HasButtonDesign;

use SudoBee\Cygnus\Component\Component;
use SudoBee\Cygnus\Component\Traits\HasButtonDesign;
use SudoBee\Cygnus\Core\Utilities\ExportBuilder;

class TestComponentWithHasButtonDesignTrait extends Component
{
	use HasButtonDesign;

	public function export(): array
	{
		return ExportBuilder::make($this)
			->mergeProperties($this->buttonDesignExport())
			->export();
	}
}
