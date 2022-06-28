<?php

namespace Arpite\Arpite\Tests\Unit\Component\Traits\HasIcon;

use Arpite\Arpite\Component\Component;
use Arpite\Arpite\Component\Traits\HasIcon;
use Arpite\Arpite\Core\Utilities\ExportBuilder;

class TestComponentWithHasIconTrait extends Component
{
	use HasIcon;

	public function export(): array
	{
		return ExportBuilder::make($this)
			->mergeProperties($this->iconExport())
			->export();
	}
}
