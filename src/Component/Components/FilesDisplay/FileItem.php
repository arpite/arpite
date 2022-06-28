<?php

namespace Arpite\Arpite\Component\Components\FilesDisplay;

use Arpite\Arpite\Component\Component;
use Arpite\Arpite\Component\Traits\HasNodes;
use Arpite\Arpite\Component\Traits\HasTitle;
use Arpite\Arpite\Core\Utilities\ExportBuilder;

class FileItem extends Component
{
	use HasTitle;
	use HasNodes;

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
			->mergeProperties($this->nodesExport())
			->export();
	}
}
