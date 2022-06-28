<?php

namespace Arpite\Arpite\Component\Components\PricingPlans;

use Arpite\Arpite\Component\Component;
use Arpite\Arpite\Component\Traits\HasButtons;
use Arpite\Arpite\Component\Traits\HasDescription;
use Arpite\Arpite\Component\Traits\HasTitle;
use Arpite\Arpite\Core\Utilities\ExportBuilder;

class CurrentPricingPlan extends Component
{
	use HasTitle;
	use HasDescription;
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
			->mergeProperties($this->buttonsExport())
			->export();
	}
}
