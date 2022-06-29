<?php

namespace Arpite\Tests\Unit\Component\Traits\HasButtons;

use Arpite\Component\Component;
use Arpite\Component\Traits\HasButtons;
use Arpite\Core\Utilities\ExportBuilder;

class TestComponentWithHasButtonsTrait extends Component
{
	use HasButtons;

	public function export(): array
	{
		return ExportBuilder::make($this)
			->mergeProperties($this->buttonsExport())
			->export();
	}
}
