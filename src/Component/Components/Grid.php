<?php

namespace SudoBee\Cygnus\Component\Components;

use SudoBee\Cygnus\Component\Component;
use SudoBee\Cygnus\Component\ResponsiveValue;
use SudoBee\Cygnus\Component\Traits\HasGap;
use SudoBee\Cygnus\Component\Traits\HasNodes;
use SudoBee\Cygnus\Core\Utilities\ExportBuilder;

class Grid extends Component
{
	use HasNodes;
	use HasGap;

	/** @var ResponsiveValue<array<int, int>> $columns */
	private ResponsiveValue $columns;

	private function __construct()
	{
		$this->columns = ResponsiveValue::make([1]);

		$this->setGap(4);
	}

	public static function make(): self
	{
		return new self();
	}

	/**
	 * @param array<int, int> $default
	 * @param array<int, int>|null $sm
	 * @param array<int, int>|null $md
	 * @param array<int, int>|null $lg
	 * @param array<int, int>|null $xl
	 * @return static
	 */
	public function setColumns(
		array $default = [1],
		array|null $sm = null,
		array|null $md = null,
		array|null $lg = null,
		array|null $xl = null
	) {
		$this->columns = ResponsiveValue::make($default, $sm, $md, $lg, $xl);

		return $this;
	}

	/**
	 * @return array<string, mixed>
	 */
	public function export(): array
	{
		return ExportBuilder::make($this)
			->mergeProperties($this->nodesExport())
			->mergeProperties($this->gapExport())
			->addProperty("columns", $this->columns)
			->export();
	}
}
