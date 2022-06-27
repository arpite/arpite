<?php

namespace SudoBee\Cygnus\Tests\Unit\Component\Traits\HasImage;

use SudoBee\Cygnus\Component\Component;
use SudoBee\Cygnus\Component\Traits\HasImage;
use SudoBee\Cygnus\Core\Utilities\ExportBuilder;

class TestComponentWithHasImageTrait extends Component
{
	use HasImage;

	public function export(): array
	{
		return ExportBuilder::make($this)
			->mergeProperties($this->imageExport())
			->export();
	}
}
