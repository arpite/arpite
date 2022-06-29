<?php

namespace Arpite\Tests\Unit\Component\Traits;

use Arpite\Component\Component;
use Arpite\Component\Traits\HasActions;
use Arpite\Core\Utilities\ExportBuilder;

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
