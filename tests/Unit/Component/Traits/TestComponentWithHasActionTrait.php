<?php

namespace Arpite\Tests\Unit\Component\Traits;

use Arpite\Component\Component;
use Arpite\Component\Traits\HasAction;
use Arpite\Core\Utilities\ExportBuilder;

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
