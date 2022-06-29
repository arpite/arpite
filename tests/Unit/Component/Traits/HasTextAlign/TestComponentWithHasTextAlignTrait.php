<?php

namespace Arpite\Tests\Unit\Component\Traits\HasTextAlign;

use Arpite\Component\Component;
use Arpite\Component\Traits\HasTextAlign;
use Arpite\Core\Utilities\ExportBuilder;

class TestComponentWithHasTextAlignTrait extends Component
{
	use HasTextAlign;

	public function export(): array
	{
		return ExportBuilder::make()
			->mergeProperties($this->textAlignExport())
			->export();
	}
}
