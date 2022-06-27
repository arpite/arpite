<?php

namespace SudoBee\Cygnus\Component\Components\PaginatedTable;

use SudoBee\Cygnus\Component\Components\PaginatedTable\Actions\GeneratePaginationLinksAction;
use SudoBee\Cygnus\Component\Components\Table\Table;
use SudoBee\Cygnus\Component\Components\Table\TableRow;
use SudoBee\Cygnus\Core\Utilities\ExportBuilder;
use Exception;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

class PaginatedTable extends Table
{
	private int $perPage = 10;

	/** @var Relation<Model>|Builder<Model>|\Illuminate\Database\Query\Builder|null $query  */
	private Relation|Builder|\Illuminate\Database\Query\Builder|null $query = null;

	/** @var callable(Model): TableRow */
	private $row;

	public static function make(): self
	{
		return new PaginatedTable();
	}

	/**
	 * @param Relation<Model>|Builder<Model>|\Illuminate\Database\Query\Builder $query
	 * @return static
	 */
	public function setQuery(
		Relation|Builder|\Illuminate\Database\Query\Builder $query
	) {
		$this->query = $query;

		return $this;
	}

	/**
	 * @param int $perPage
	 * @return static
	 */
	public function setPerPage(int $perPage)
	{
		$this->perPage = $perPage;

		return $this;
	}

	/**
	 * @param callable(Model): TableRow $row
	 * @return static
	 */
	public function setRow(callable $row)
	{
		$this->row = $row;

		return $this;
	}

	/**
	 * @param Paginator $pagination
	 * @return TableRow[]
	 */
	private function transformPaginationItems(Paginator $pagination): array
	{
		return array_map(function (Model $item) {
			/**
			 * @var TableRow
			 */
			return ($this->row)($item);
		}, $pagination->items());
	}

	/**
	 * @return array<mixed>
	 * @throws Exception
	 */
	public function export(): array
	{
		if ($this->query === null) {
			throw new Exception(
				'Query must be set for PaginatedTable. Use "setQuery" method.'
			);
		}

		if ($this->row === null) {
			throw new Exception(
				'Row function must be set for PaginatedTable. Use "setRow" method.'
			);
		}

		/**
		 * When PaginatedTable is being rendered together with a panel Table class gets
		 * exported which triggers second export for PaginatedTable. To avoid running
		 * expensive query call twice, we first export Table alone, and leave the
		 * expensive query function only for the second export call.
		 */
		if ($this->withPanel) {
			return ExportBuilder::make($this)
				->mergeProperties(parent::export())
				->export();
		}

		/** @phpstan-ignore-next-line */
		$totalCount = $this->query->count();

		/** @phpstan-ignore-next-line */
		$pagination = $this->query->simplePaginate($this->perPage);

		$this->setRows($this->transformPaginationItems($pagination));

		$paginationLinksProperties = app(
			GeneratePaginationLinksAction::class
		)->execute(
			currentPageIndex: $pagination->currentPage() - 1,
			perPage: $this->perPage,
			totalCount: $totalCount
		);

		return ExportBuilder::make($this)
			->mergeProperties(parent::export())
			->addProperty("total", $totalCount)
			->addProperty("from", $pagination->firstItem())
			->addProperty("to", $pagination->lastItem())
			->addProperty("links", $paginationLinksProperties["links"])
			->addProperty(
				"previousPageUrl",
				$paginationLinksProperties["previousPageUrl"]
			)
			->addProperty(
				"nextPageUrl",
				$paginationLinksProperties["nextPageUrl"]
			)
			->export();
	}
}
