<?php

namespace Arpite\Tests\Unit\Component\Traits\HasImage;

use Arpite\Component\Component;
use Arpite\Component\Traits\HasImage;
use Arpite\Core\Utilities\ExportBuilder;

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
