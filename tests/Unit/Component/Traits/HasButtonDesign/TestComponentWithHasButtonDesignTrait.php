<?php

namespace Arpite\Arpite\Tests\Unit\Component\Traits\HasButtonDesign;

use Arpite\Arpite\Component\Component;
use Arpite\Arpite\Component\Traits\HasButtonDesign;
use Arpite\Arpite\Core\Utilities\ExportBuilder;

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
