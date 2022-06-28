<?php

namespace Arpite\Arpite\Tests\Unit\Component\Traits;

use Arpite\Arpite\Component\Component;
use Arpite\Arpite\Component\Traits\HasDisabled;
use Arpite\Arpite\Core\Utilities\ExportBuilder;

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
