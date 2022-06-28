<?php

namespace Arpite\Arpite\Tests\Unit\Component\Traits\HasButtonColor;

use Arpite\Arpite\Component\Component;
use Arpite\Arpite\Component\Traits\HasButtonColor;
use Arpite\Arpite\Core\Utilities\ExportBuilder;

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
