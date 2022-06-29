<?php

namespace Arpite\Component\Components\PricingPlans;

use Arpite\Component\Component;
use Arpite\Component\Traits\HasButtons;
use Arpite\Component\Traits\HasDescription;
use Arpite\Component\Traits\HasTitle;
use Arpite\Core\Utilities\ExportBuilder;

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
