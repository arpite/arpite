<?php

namespace Arpite\Arpite\Tests\Unit\Component\Traits;

use Arpite\Arpite\Component\Component;
use Arpite\Arpite\Component\Traits\HasAction;
use Arpite\Arpite\Core\Utilities\ExportBuilder;

class TestComponentWithHasActionTrait extends Component
{
	use HasAction;

	public function export(): array
	{
		return ExportBuilder::make($this)
			->mergeProperties($this->actionExport())
			->export();
	}
}
