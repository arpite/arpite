<?php

namespace Arpite\Arpite\Tests\Unit\Component\Traits;

use Arpite\Arpite\Component\Component;
use Arpite\Arpite\Component\Traits\HasWithPanel;
use Arpite\Arpite\Core\Utilities\ExportBuilder;

class TestComponentWithHasWithPanelTrait extends Component
{
	use HasWithPanel;

	public function export(): array
	{
		return ExportBuilder::make($this)
			->mergeProperties($this->withPanelExport())
			->export();
	}
}
