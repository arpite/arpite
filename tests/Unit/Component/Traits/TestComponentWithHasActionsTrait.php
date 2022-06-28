<?php

namespace Arpite\Arpite\Tests\Unit\Component\Traits;

use Arpite\Arpite\Component\Component;
use Arpite\Arpite\Component\Traits\HasActions;
use Arpite\Arpite\Core\Utilities\ExportBuilder;

class TestComponentWithHasActionsTrait extends Component
{
	use HasActions;

	public function export(): array
	{
		return ExportBuilder::make($this)
			->mergeProperties($this->actionsExport())
			->export();
	}
}
