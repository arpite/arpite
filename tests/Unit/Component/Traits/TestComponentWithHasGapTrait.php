<?php

namespace Arpite\Tests\Unit\Component\Traits;

use Arpite\Component\Component;
use Arpite\Component\Traits\HasGap;
use Arpite\Core\Utilities\ExportBuilder;

class TestComponentWithHasGapTrait extends Component
{
	use HasGap;

	public function export(): array
	{
		return ExportBuilder::make($this)
			->mergeProperties($this->gapExport())
			->export();
	}
}
