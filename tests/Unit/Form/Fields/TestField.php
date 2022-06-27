<?php

namespace SudoBee\Cygnus\Tests\Unit\Form\Fields;

use SudoBee\Cygnus\Core\Utilities\ExportBuilder;
use SudoBee\Cygnus\Form\Fields\Field;

class TestField extends Field
{
	public function export(): array
	{
		return ExportBuilder::make($this)
			->mergeProperties($this->fieldExport())
			->export();
	}
}
