<?php

namespace Arpite\Tests\Unit\Component;

use Arpite\Component\ButtonTemplate;
use Arpite\Core\Utilities\ExportBuilder;

class TestButtonTemplateComponent extends ButtonTemplate
{
	public function export(): array
	{
		return ExportBuilder::make($this)
			->mergeProperties($this->buttonTemplateExport())
			->export();
	}
}
