<?php

namespace Arpite\Arpite\Tests\Unit\Component;

use Arpite\Arpite\Component\ButtonTemplate;
use Arpite\Arpite\Core\Utilities\ExportBuilder;

class TestButtonTemplateComponent extends ButtonTemplate
{
	public function export(): array
	{
		return ExportBuilder::make($this)
			->mergeProperties($this->buttonTemplateExport())
			->export();
	}
}
