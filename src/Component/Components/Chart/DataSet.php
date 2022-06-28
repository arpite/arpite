<?php

namespace Arpite\Arpite\Component\Components\Chart;

use Arpite\Arpite\Core\Interfaces\Exportable;
use Arpite\Arpite\Core\Utilities\ExportBuilder;

class DataSet implements Exportable
{
	private string $label;

	/** @var array<int, int> */
	private array $data;

	private ?string $backgroundColor = null;

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
	 * @param ?string $backgroundColor
	 * @return $this
	 */
	public function setBackgroundColor(?string $backgroundColor): self
	{
		$this->backgroundColor = $backgroundColor;

		return $this;
	}

	public function getBackgroundColor(): ?string
	{
		return $this->backgroundColor;
	}

	public function getLabel(): string
	{
		return $this->label;
	}

	public function export(): array
	{
		return ExportBuilder::make()
			->addProperty("label", $this->label)
			->addProperty("data", $this->data)
			->addProperty("backgroundColor", $this->backgroundColor)
			->export();
	}
}
