<?php

namespace SudoBee\Cygnus\Tests\Unit\Component\Traits\HasTextAlign;

use SudoBee\Cygnus\Component\Component;
use SudoBee\Cygnus\Component\Traits\HasTextAlign;
use SudoBee\Cygnus\Core\Utilities\ExportBuilder;

class TestComponentWithHasTextAlignTrait extends Component
{
	use HasTextAlign;

	public function export(): array
	{
		return ExportBuilder::make()
			->mergeProperties($this->textAlignExport())
			->export();
	}
}
