<?php

namespace Arpite\Tests\Unit\Component\Traits;

use Arpite\Component\Component;
use Arpite\Component\Traits\HasDisabled;
use Arpite\Core\Utilities\ExportBuilder;

class TestComponentWithHasDisabledTrait extends Component
{
	use HasDisabled;

	public function export(): array
	{
		return ExportBuilder::make($this)
			->mergeProperties($this->disabledExport())
			->export();
	}
}
