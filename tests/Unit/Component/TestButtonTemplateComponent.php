<?php

namespace SudoBee\Cygnus\Tests\Unit\Component;

use SudoBee\Cygnus\Component\ButtonTemplate;
use SudoBee\Cygnus\Core\Utilities\ExportBuilder;

class TestButtonTemplateComponent extends ButtonTemplate
{
	public function export(): array
	{
		return ExportBuilder::make($this)
			->mergeProperties($this->buttonTemplateExport())
			->export();
	}
}
