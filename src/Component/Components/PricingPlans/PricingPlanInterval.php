<?php

namespace SudoBee\Cygnus\Component\Components\PricingPlans;

use SudoBee\Cygnus\Component\Component;
use SudoBee\Cygnus\Component\Traits\HasButtons;
use SudoBee\Cygnus\Core\Utilities\ExportBuilder;

class PricingPlanInterval extends Component
{
	use HasButtons;

	private bool $active = false;

	private int $price = 0;

	public static function make(): self
	{
		return new self();
	}

	/**
	 * @param int $price
	 * @return static
	 */
	public function setPrice(int $price)
	{
		$this->price = $price;

		return $this;
	}

	/**
	 * @param bool $active
	 * @return static
	 */
	public function active(bool $active = true)
	{
		$this->active = $active;

		return $this;
	}

	/**
	 * @return array<mixed>
	 */
	public function export(): array
	{
		return ExportBuilder::make($this)
			->mergeProperties($this->buttonsExport())
			->addProperty("price", $this->price)
			->addProperty("active", $this->active)
			->export();
	}
}
