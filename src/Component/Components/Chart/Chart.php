<?php

namespace Arpite\Component\Components\Chart;

use Arpite\Component\Component;
use Arpite\Component\Components\Chart\Enums\DataType;
use Arpite\Core\Utilities\ExportBuilder;

class Chart extends Component
{
	/** @var array<int, string> */
	private array $labels = [];

	/** @var array<int, DataSet> */
	private array $dataSets = [];

	private string $dataType = DataType::NUMBERS;

	private ?string $xAxisLabel = null;

	private ?string $yAxisLabel = null;

	private bool $isStacked = false;

	private int $height = 320;

	public static function make(): self
	{
		return new self();
	}

	/**
	 * @param array<int, string> $labels
	 * @return $this
	 */
	public function setLabels(array $labels): self
	{
		$this->labels = $labels;

		return $this;
	}

	/**
	 * @param array<int, DataSet> $dataSets
	 * @return $this
	 */
	public function setDataSets(array $dataSets): self
	{
		$this->dataSets = $dataSets;

		return $this;
	}

	public function setDataType(string $type): self
	{
		$this->dataType = $type;

		return $this;
	}

	public function setXAxisLabel(?string $label): self
	{
		$this->xAxisLabel = $label;

		return $this;
	}

	public function setYAxisLabel(?string $label): self
	{
		$this->yAxisLabel = $label;

		return $this;
	}

	/**
	 * @return $this
	 */
	public function asStacked(): self
	{
		$this->isStacked = true;

		return $this;
	}

	/**
	 * @param int $height
	 * @return static
	 */
	public function setHeight(int $height): self
	{
		$this->height = $height;

		return $this;
	}

	public function export(): array
	{
		return ExportBuilder::make($this)
			->addNodesProperty("dataSets", $this->dataSets)
			->addProperty("labels", $this->labels)
			->addProperty("dataType", $this->dataType)
			->addProperty("xAxisLabel", __($this->xAxisLabel))
			->addProperty("yAxisLabel", __($this->yAxisLabel))
			->addProperty("stacked", $this->isStacked)
			->addProperty("height", $this->height)
			->export();
	}
}
