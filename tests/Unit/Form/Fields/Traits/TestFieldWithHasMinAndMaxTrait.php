<?php

namespace Arpite\Arpite\Tests\Unit\Form\Fields\Traits;

use Arpite\Arpite\Core\Utilities\ExportBuilder;
use Arpite\Arpite\Form\Fields\Field;
use Arpite\Arpite\Form\Fields\Traits\HasMinAndMax;

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
