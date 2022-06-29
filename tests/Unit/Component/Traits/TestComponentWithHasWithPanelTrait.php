<?php

namespace Arpite\Tests\Unit\Component\Traits;

use Arpite\Component\Component;
use Arpite\Component\Traits\HasWithPanel;
use Arpite\Core\Utilities\ExportBuilder;

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
