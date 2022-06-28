<?php

namespace Arpite\Arpite\Tests\Unit\Component\Traits\HasTextAlign;

use Arpite\Arpite\Component\Component;
use Arpite\Arpite\Component\Traits\HasTextAlign;
use Arpite\Arpite\Core\Utilities\ExportBuilder;

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
