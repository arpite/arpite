<?php

namespace SudoBee\Cygnus\Component\Components;

use SudoBee\Cygnus\Component\Component;
use SudoBee\Cygnus\Component\Traits\HasActions;
use SudoBee\Cygnus\Component\Traits\HasDescription;
use SudoBee\Cygnus\Component\Traits\HasNodes;
use SudoBee\Cygnus\Component\Traits\HasTitle;
use SudoBee\Cygnus\Core\Utilities\ExportBuilder;

class Panel extends Component
{
	use HasTitle;
	use HasDescription;
	use HasNodes;
	use HasActions;

	private int $padding = 6;

	public static function make(): self
	{
		return new self();
	}

	/**
	 * @param int<0, 12> $padding
	 * @return static
	 */
	public function setPadding(int $padding)
	{
		$this->padding = $padding;

		return $this;
	}

	/**
	 * @return array<mixed>
	 */
	public function export(): array
	{
		return ExportBuilder::make($this)
			->mergeProperties($this->titleExport())
			->mergeProperties($this->descriptionExport())
			->mergeProperties($this->nodesExport())
			->mergeProperties($this->actionsExport())
			->addProperty("padding", $this->padding)
			->export();
	}
}
