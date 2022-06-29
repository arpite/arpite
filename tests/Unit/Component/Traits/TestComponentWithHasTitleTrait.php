<?php

namespace Arpite\Tests\Unit\Component\Traits;

use Arpite\Component\Component;
use Arpite\Component\Traits\HasTitle;
use Arpite\Core\Utilities\ExportBuilder;

class TestComponentWithHasTitleTrait extends Component
{
	use HasTitle;

	public function export(): array
	{
		return ExportBuilder::make($this)
			->mergeProperties($this->titleExport())
			->export();
	}
}
