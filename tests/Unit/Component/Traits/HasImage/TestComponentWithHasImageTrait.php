<?php

namespace Arpite\Arpite\Tests\Unit\Component\Traits\HasImage;

use Arpite\Arpite\Component\Component;
use Arpite\Arpite\Component\Traits\HasImage;
use Arpite\Arpite\Core\Utilities\ExportBuilder;

class TestComponentWithHasImageTrait extends Component
{
	use HasImage;

	public function export(): array
	{
		return ExportBuilder::make($this)
			->mergeProperties($this->imageExport())
			->export();
	}
}
