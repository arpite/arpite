<?php

namespace Arpite\Arpite\Tests\Unit\Component;

use Arpite\Arpite\Component\Component;
use Arpite\Arpite\Core\Utilities\ExportBuilder;

class TestComponent extends Component
{
	public function export(): array
	{
		return ExportBuilder::make($this)->export();
	}
}
