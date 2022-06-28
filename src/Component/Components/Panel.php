<?php

namespace Arpite\Arpite\Component\Components;

use Arpite\Arpite\Component\Component;
use Arpite\Arpite\Component\Traits\HasActions;
use Arpite\Arpite\Component\Traits\HasDescription;
use Arpite\Arpite\Component\Traits\HasNodes;
use Arpite\Arpite\Component\Traits\HasTitle;
use Arpite\Arpite\Core\Utilities\ExportBuilder;

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
