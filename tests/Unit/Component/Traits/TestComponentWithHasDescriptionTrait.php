<?php

namespace Arpite\Arpite\Tests\Unit\Component\Traits;

use Arpite\Arpite\Component\Component;
use Arpite\Arpite\Component\Traits\HasDescription;
use Arpite\Arpite\Core\Utilities\ExportBuilder;

class TestComponentWithHasDescriptionTrait extends Component
{
	use HasDescription;

	public function export(): array
	{
		return ExportBuilder::make($this)
			->mergeProperties($this->descriptionExport())
			->export();
	}
}
