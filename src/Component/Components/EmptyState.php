<?php

namespace Arpite\Component\Components;

use Arpite\Component\Component;
use Arpite\Component\Traits\HasButtons;
use Arpite\Component\Traits\HasDescription;
use Arpite\Component\Traits\HasImage;
use Arpite\Component\Traits\HasTitle;
use Arpite\Core\Utilities\ExportBuilder;

class EmptyState extends Component
{
	use HasTitle;
	use HasDescription;
	use HasImage;
	use HasButtons;

	public static function make(): self
	{
		return new self();
	}

	/**
	 * @return array<mixed>
	 */
	public function export(): array
	{
		return ExportBuilder::make($this)
			->mergeProperties($this->titleExport())
			->mergeProperties($this->descriptionExport())
			->mergeProperties($this->imageExport())
			->mergeProperties($this->buttonsExport())
			->export();
	}
}
