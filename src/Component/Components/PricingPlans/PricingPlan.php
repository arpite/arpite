<?php

namespace SudoBee\Cygnus\Component\Components\PricingPlans;

use SudoBee\Cygnus\Component\Component;
use SudoBee\Cygnus\Component\Traits\HasButtons;
use SudoBee\Cygnus\Component\Traits\HasDescription;
use SudoBee\Cygnus\Component\Traits\HasTitle;
use SudoBee\Cygnus\Core\Utilities\ExportBuilder;

class PricingPlan extends Component
{
	use HasTitle;
	use HasDescription;
	use HasButtons;

	private PricingPlanInterval $monthlyInterval;
	private PricingPlanInterval $yearlyInterval;

	/**
	 * @var array<int, string> $features
	 */
	private array $features = [];

	public static function make(): self
	{
		return new self();
	}

	/**
	 * @param array<int, string> $features
	 * @return static
	 */
	public function setFeatures(array $features)
	{
		$this->features = $features;

		return $this;
	}

	/**
	 * @param PricingPlanInterval $monthlyInterval
	 * @return static
	 */
	public function setMonthlyInterval(PricingPlanInterval $monthlyInterval)
	{
		$this->monthlyInterval = $monthlyInterval;

		return $this;
	}

	/**
	 * @param PricingPlanInterval $yearlyInterval
	 * @return static
	 */
	public function setYearlyInterval(PricingPlanInterval $yearlyInterval)
	{
		$this->yearlyInterval = $yearlyInterval;

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
			->mergeProperties($this->buttonsExport())
			->addProperty("monthlyInterval", $this->monthlyInterval)
			->addProperty("yearlyInterval", $this->yearlyInterval)
			->addProperty("features", $this->features)
			->export();
	}
}
