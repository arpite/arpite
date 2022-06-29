<?php

namespace Arpite\Component\Components\Metric;

use Arpite\Component\Component;
use Arpite\Component\Components\Metric\Enums\MetricTrend;
use Arpite\Component\Traits\HasIcon;
use Arpite\Component\Traits\HasTitle;
use Arpite\Core\Utilities\ExportBuilder;

class Metric extends Component
{
	use HasTitle;
	use HasIcon;

	private string|int|float|null $value = null;

	private int|null $change = null;

	private string|null $changeText = null;

	// TODO: rename trend to better name. it determines the color of the change
	private MetricTrend|null $changeTrend = null;

	private bool $invertChangeTrend = false;

	public static function make(): self
	{
		return new self();
	}

	/**
	 * @param string|int|float|null $value
	 * @return static
	 */
	public function setValue(string|int|float|null $value)
	{
		$this->value = $value;

		return $this;
	}

	/**
	 * @param int|null $change
	 * @return static
	 */
	public function setChange(int|null $change)
	{
		$this->change = $change;

		return $this;
	}

	/**
	 * @param MetricTrend $changeTrend
	 * @return static
	 */
	public function setChangeTrend(MetricTrend $changeTrend)
	{
		$this->changeTrend = $changeTrend;

		return $this;
	}

	/**
	 * @param ?string $changeText
	 * @return static
	 */
	public function setChangeText(?string $changeText)
	{
		$this->changeText = $changeText;

		return $this;
	}
	/**
	 * @param bool $invert
	 * @return static
	 */
	public function invertChangeTrend(bool $invert = true)
	{
		$this->invertChangeTrend = $invert;

		return $this;
	}

	private function getChangeTrend(): MetricTrend
	{
		if ($this->changeTrend !== null) {
			return $this->changeTrend;
		}

		$modifiedChange = $this->invertChangeTrend
			? -$this->change
			: $this->change;

		return $modifiedChange > 0
			? MetricTrend::UP
			: ($modifiedChange < 0
				? MetricTrend::DOWN
				: MetricTrend::NONE);
	}

	/**
	 * @return array<mixed>
	 */
	public function export(): array
	{
		$changeTrend = $this->getChangeTrend();

		return ExportBuilder::make($this)
			->mergeProperties($this->titleExport())
			->mergeProperties($this->iconExport())
			->addProperty("value", $this->value)
			->addProperty("change", $this->change)
			->addProperty("changeText", $this->changeText)
			->addProperty("changeTrend", $changeTrend->name)
			->export();
	}
}
