<?php

namespace Arpite\Arpite\Component\Components\Wizard;

use Arpite\Arpite\Component\Component;
use Arpite\Arpite\Component\Traits\HasNodes;
use Arpite\Arpite\Core\Utilities\ExportBuilder;

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
