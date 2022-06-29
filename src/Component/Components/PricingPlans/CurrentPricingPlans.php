<?php

namespace Arpite\Component\Components\PricingPlans;

use Arpite\Component\Component;
use Arpite\Component\Traits\HasDescription;
use Arpite\Component\Traits\HasTitle;
use Arpite\Core\Utilities\ExportBuilder;

class CurrentPricingPlans extends Component
{
	use HasTitle;
	use HasDescription;

	/**
	 * @var array<int, CurrentPricingPlan> $plans
	 */
	private array $plans = [];

	public static function make(): self
	{
		return new self();
	}

	/**
	 * @param array<int, CurrentPricingPlan> $plans
	 * @return static
	 */
	public function setPlans(array $plans)
	{
		$this->plans = $plans;

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
			->addNodesProperty("plans", $this->plans)
			->export();
	}
}
