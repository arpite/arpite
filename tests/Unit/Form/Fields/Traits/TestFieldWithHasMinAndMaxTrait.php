<?php

namespace Arpite\Tests\Unit\Form\Fields\Traits;

use Arpite\Core\Utilities\ExportBuilder;
use Arpite\Form\Fields\Field;
use Arpite\Form\Fields\Traits\HasMinAndMax;

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
