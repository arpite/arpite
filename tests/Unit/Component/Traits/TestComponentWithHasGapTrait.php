<?php

namespace Arpite\Arpite\Tests\Unit\Component\Traits;

use Arpite\Arpite\Component\Component;
use Arpite\Arpite\Component\Traits\HasGap;
use Arpite\Arpite\Core\Utilities\ExportBuilder;

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
