<?php

namespace Arpite\Arpite\Component\Components\PaginatedTable\Actions;

use Illuminate\Support\Arr;

class GeneratePaginationLinksAction
{
	/**
	 * @param int $currentPageIndex
	 * @param int $perPage
	 * @param int $totalCount
	 * @return array{
	 *      links: array<int, array{
	 *          url: string|null,
	 *          label: numeric-string,
	 *          active: bool
	 *      }>,
	 *      previousPageUrl: string|null,
	 *      nextPageUrl: string|null
	 * }
	 */
	public function execute(
		int $currentPageIndex,
		int $perPage,
		int $totalCount
	): array {
		$maxPageCount = 5;

		$totalPagesCount = (int) ceil($totalCount / $perPage);

		$startPage = max(
			0,
			abs(0 - $currentPageIndex) - (int) ($maxPageCount / 2)
		);
		$lastPossiblePage = $startPage + $maxPageCount;
		$startPage =
			$startPage -
			($lastPossiblePage > $totalPagesCount
				? $lastPossiblePage - $totalPagesCount
				: 0);

		$links = [];
		for (
			$pageIndex = max(0, $startPage);
			$pageIndex < $startPage + $maxPageCount;
			$pageIndex++
		) {
			$links[] = [
				"url" => $this->constructFullUrl($pageIndex),
				"label" => (string) ($pageIndex + 1),
				"active" => $pageIndex === $currentPageIndex,
			];
		}

		return [
			"links" => $links,
			"previousPageUrl" => $this->constructFullUrl(
				$currentPageIndex <= 0 ? null : $currentPageIndex - 1
			),
			"nextPageUrl" => $this->constructFullUrl(
				$currentPageIndex >= $totalPagesCount - 1
					? null
					: $currentPageIndex + 1
			),
		];
	}

	private function constructFullUrl(int|null $pageIndex): string|null
	{
		if ($pageIndex === null) {
			return null;
		}

		/** @var array<string, mixed> $oldParameters */
		$oldParameters = request()->query();

		$parameters = array_merge($oldParameters, [
			"page" => $pageIndex + 1,
		]);

		return url()->current() . "?" . Arr::query($parameters);
	}
}
