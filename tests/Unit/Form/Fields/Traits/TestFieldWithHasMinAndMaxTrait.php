<?php

namespace SudoBee\Cygnus\Tests\Unit\Form\Fields\Traits;

use SudoBee\Cygnus\Core\Utilities\ExportBuilder;
use SudoBee\Cygnus\Form\Fields\Field;
use SudoBee\Cygnus\Form\Fields\Traits\HasMinAndMax;

class TestFieldWithHasMinAndMaxTrait extends Field
{
	use HasMinAndMax;

	public function export(): array
	{
		return ExportBuilder::make($this)
			->mergeProperties($this->fieldExport())
			->mergeProperties($this->minAndMaxExport())
			->export();
	}
}
