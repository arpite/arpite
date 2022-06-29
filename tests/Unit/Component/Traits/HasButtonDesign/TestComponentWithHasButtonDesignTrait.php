<?php

namespace Arpite\Tests\Unit\Component\Traits\HasButtonDesign;

use Arpite\Component\Component;
use Arpite\Component\Traits\HasButtonDesign;
use Arpite\Core\Utilities\ExportBuilder;

class TestComponentWithHasButtonDesignTrait extends Component
{
	use HasButtonDesign;

	public function export(): array
	{
		return ExportBuilder::make($this)
			->mergeProperties($this->buttonDesignExport())
			->export();
	}
}
