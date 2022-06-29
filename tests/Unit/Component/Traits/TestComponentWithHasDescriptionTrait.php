<?php

namespace Arpite\Tests\Unit\Component\Traits;

use Arpite\Component\Component;
use Arpite\Component\Traits\HasDescription;
use Arpite\Core\Utilities\ExportBuilder;

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
