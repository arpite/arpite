<?php

namespace SudoBee\Cygnus\Tests\Unit\Component\Traits;

use SudoBee\Cygnus\Component\Component;
use SudoBee\Cygnus\Component\Traits\HasDescription;
use SudoBee\Cygnus\Core\Utilities\ExportBuilder;

class TestComponentWithHasDescriptionTrait extends Component
{
	use HasDescription;

	public function export(): array
	{
		return ExportBuilder::make($this)
			->mergeProperties($this->descriptionExport())
			->export();
	}
}
