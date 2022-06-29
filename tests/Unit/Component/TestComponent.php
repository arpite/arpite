<?php

namespace Arpite\Tests\Unit\Component;

use Arpite\Component\Component;
use Arpite\Core\Utilities\ExportBuilder;

class TestComponent extends Component
{
	public function export(): array
	{
		return ExportBuilder::make($this)->export();
	}
}
