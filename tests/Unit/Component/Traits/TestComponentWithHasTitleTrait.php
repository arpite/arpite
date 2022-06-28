<?php

namespace Arpite\Arpite\Tests\Unit\Component\Traits;

use Arpite\Arpite\Component\Component;
use Arpite\Arpite\Component\Traits\HasTitle;
use Arpite\Arpite\Core\Utilities\ExportBuilder;

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
