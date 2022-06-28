<?php

namespace Arpite\Arpite\Tests\Unit\Component\Traits\HasButtons;

use Arpite\Arpite\Component\Component;
use Arpite\Arpite\Component\Traits\HasButtons;
use Arpite\Arpite\Core\Utilities\ExportBuilder;

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
