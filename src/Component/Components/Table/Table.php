<?php

namespace Arpite\Arpite\Component\Components\Table;

use Arpite\Arpite\Component\Component;
use Arpite\Arpite\Component\Components\EmptyState;
use Arpite\Arpite\Component\Components\Panel;
use Arpite\Arpite\Component\Traits\HasActions;
use Arpite\Arpite\Component\Traits\HasDescription;
use Arpite\Arpite\Component\Traits\HasTitle;
use Arpite\Arpite\Component\Traits\HasWithPanel;
use Arpite\Arpite\Core\Utilities\ExportBuilder;
use Exception;
use Illuminate\Support\Str;

class Table extends Component
{
	use HasTitle;
	use HasDescription;
	use HasActions;
	use HasWithPanel;

	/**
	 * @var array<int|string, mixed>
	 */
	private array $columns = [];

	/**
	 * @var TableRow[]
	 */
	private array $rows = [];

	/**
	 * @var int[]
	 */
	private array $widths = [];

	/**
	 * @var Component[]
	 */
	private array $panelActions = [];

	private ?EmptyState $emptyState = null;

	private bool $asPairTable = false;

	public static function make(): Table
	{
		return new Table();
	}

	/**
	 * @param string|null $translatableTitle
	 * @param string|null $identifier
	 * @return static
	 * @throws Exception
	 */
	public function addColumn(
		?string $translatableTitle,
		?string $identifier = null
	) {
		if (!$this->isColumnPropertiesValid($translatableTitle, $identifier)) {
			throw new Exception(
				'Table column $identifier must be provided when given $title is null or empty string.'
			);
		}

		$this->columns[] = [
			"title" =>
				$translatableTitle === null ? "" : __($translatableTitle),
			/**
			 * @phpstan-ignore-next-line
			 */
			"identifier" => $identifier ?? Str::slug($translatableTitle),
		];

		return $this;
	}

	/**
	 * @return static
	 * @throws Exception
	 */
	public function addLinksColumn()
	{
		$this->addColumn(null, "links");

		return $this;
	}

	/**
	 * @param TableRow $row
	 * @return static
	 */
	public function addRow(TableRow $row)
	{
		$this->rows[] = $row;

		return $this;
	}

	/**
	 * @param TableRow[] $rows
	 * @return static
	 */
	public function setRows(array $rows)
	{
		$this->rows = $rows;

		return $this;
	}

	/**
	 * @param int ...$widths
	 * @return static
	 */
	public function setWidths(int ...$widths)
	{
		$this->widths = $widths;

		return $this;
	}

	/**
	 * @param (callable(): EmptyState|null)|EmptyState|null $emptyState
	 * @return static
	 */
	public function setEmptyState($emptyState)
	{
		if (is_callable($emptyState)) {
			$this->emptyState = $emptyState();
		} else {
			$this->emptyState = $emptyState;
		}

		return $this;
	}

	/**
	 * @param bool $asPairTable
	 * @return static
	 */
	public function asPairTable(bool $asPairTable = true)
	{
		$this->asPairTable = $asPairTable;

		return $this;
	}

	/**
	 * @param Component[] $panelActions
	 * @return static
	 */
	public function setPanelActions(array $panelActions)
	{
		$this->panelActions = $panelActions;

		return $this;
	}

	/**
	 * @param int[] $widths
	 * @return double[]
	 */
	private function transformWidthsToPercentages(array $widths): array
	{
		$sum = array_reduce(
			$widths,
			fn($previous, $width) => $previous + $width,
			0
		);

		return array_map(
			fn($width) => round(($width / $sum) * 100, 2),
			$widths
		);
	}

	private function isColumnPropertiesValid(
		?string $translatableTitle,
		?string $identifier
	): bool {
		return ($translatableTitle !== null && $translatableTitle !== "") ||
			$identifier !== null;
	}

	/**
	 * @return array<string, mixed>
	 */
	public function export(): array
	{
		if (!$this->withPanel) {
			$widths = $this->transformWidthsToPercentages($this->widths);

			return ExportBuilder::make($this)
				->mergeProperties($this->actionsExport())
				->addNodesProperty("rows", $this->rows)
				->addProperty("columns", $this->columns)
				->addProperty("widths", $widths)
				->addProperty("asPairTable", $this->asPairTable)
				->addProperty("emptyState", $this->emptyState)
				->export();
		}

		return Panel::make()
			->setTitle($this->title)
			->setDescription($this->description)
			->setActions($this->panelActions)
			->setNodes([$this->withoutPanel()])
			->export();
	}
}
