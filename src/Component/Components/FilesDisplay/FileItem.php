<?php

namespace SudoBee\Cygnus\Component\Components\FilesDisplay;

use SudoBee\Cygnus\Component\Component;
use SudoBee\Cygnus\Component\Traits\HasNodes;
use SudoBee\Cygnus\Component\Traits\HasTitle;
use SudoBee\Cygnus\Core\Utilities\ExportBuilder;

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
