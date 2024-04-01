<?php

namespace Arpite\Component\Components\Chart\DataSets;

use Arpite\Core\Utilities\ExportBuilder;

class LineDataSet extends DataSet
{
	private string $label;

	/** @var array<int, int> */
	private array $data;

	private int $width = 2;

	private string $color = "#111827";

	private function __construct(string $label)
	{
		$this->label = $label;
	}

	public static function make(string $label): self
	{
		return new self($label);
	}

	/**
	 * @param array<int, int> $data
	 * @return $this
	 */
	public function setData(array $data): self
	{
		$this->data = $data;

		return $this;
	}

	/**
	 * @return array<int, int>
	 */
	public function getData(): array
	{
		return $this->data;
	}

	/**
	 * @param int $width
	 * @return $this
	 */
	public function setWidth(int $width): self
	{
		$this->width = $width;

		return $this;
	}

	/**
	 * @param string $color
	 * @return $this
	 */
	public function setColor(string $color): self
	{
		$this->color = $color;

		return $this;
	}

	public function getLabel(): string
	{
		return $this->label;
	}

	public function export(): array
	{
		return ExportBuilder::make()
			->addProperty("type", "line")
			->addProperty("label", $this->label)
			->addProperty("data", $this->data)
			->addProperty("borderWidth", $this->width)
			->addProperty("borderColor", $this->color)
			->addProperty("pointBackgroundColor", $this->color)
			->export();
	}
}
