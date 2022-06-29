<?php

namespace Arpite\Tests\Unit\Component\Traits\HasButtonColor;

use Arpite\Component\Component;
use Arpite\Component\Traits\HasButtonColor;
use Arpite\Core\Utilities\ExportBuilder;

class TestComponentWithHasButtonColorTrait extends Component
{
	use HasButtonColor;

	public function export(): array
	{
		return ExportBuilder::make($this)
			->mergeProperties($this->buttonColorExport())
			->export();
	}
}
