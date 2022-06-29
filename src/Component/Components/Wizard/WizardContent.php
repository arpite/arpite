<?php

namespace Arpite\Component\Components\Wizard;

use Arpite\Component\Component;
use Arpite\Component\Traits\HasNodes;
use Arpite\Core\Utilities\ExportBuilder;

class WizardContent extends Component
{
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
			->mergeProperties($this->nodesExport())
			->export();
	}
}
