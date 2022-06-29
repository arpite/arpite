<?php

namespace Arpite\Tests\Unit\Component\Traits\HasIcon;

use Arpite\Component\Component;
use Arpite\Component\Traits\HasIcon;
use Arpite\Core\Utilities\ExportBuilder;

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
