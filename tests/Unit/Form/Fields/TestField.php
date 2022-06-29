<?php

namespace Arpite\Tests\Unit\Form\Fields;

use Arpite\Core\Utilities\ExportBuilder;
use Arpite\Form\Fields\Field;

class TestField extends Field
{
	public function export(): array
	{
		return ExportBuilder::make($this)
			->mergeProperties($this->fieldExport())
			->export();
	}
}
