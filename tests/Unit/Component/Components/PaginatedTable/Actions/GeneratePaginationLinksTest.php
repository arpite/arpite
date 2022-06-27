<?php

use SudoBee\Cygnus\Component\Components\PaginatedTable\Actions\GeneratePaginationLinksAction;

it(
	"should generate pagination links correctly when in first page",
	function () {
		$generatePaginationLinksAction = app(
			GeneratePaginationLinksAction::class
		);

		expect(
			$generatePaginationLinksAction->execute(
				currentPageIndex: 0,
				perPage: 60,
				totalCount: 50
			)
		)
			->toHaveKey("previousPageUrl", null)
			->toHaveKey("nextPageUrl", null)
			->toHaveKey("links", [
				[
					"label" => "1",
					"url" => url("?page=1"),
					"active" => true,
				],
			]);

		expect(
			$generatePaginationLinksAction->execute(
				currentPageIndex: 0,
				perPage: 30,
				totalCount: 50
			)
		)
			->toHaveKey("previousPageUrl", null)
			->toHaveKey("nextPageUrl", url("?page=2"))
			->toHaveKey("links", [
				[
					"label" => "1",
					"url" => url("?page=1"),
					"active" => true,
				],
				[
					"label" => "2",
					"url" => url("?page=2"),
					"active" => false,
				],
			]);

		expect(
			$generatePaginationLinksAction->execute(
				currentPageIndex: 0,
				perPage: 15,
				totalCount: 50
			)
		)
			->toHaveKey("previousPageUrl", null)
			->toHaveKey("nextPageUrl", url("?page=2"))
			->toHaveKey("links", [
				[
					"label" => "1",
					"url" => url("?page=1"),
					"active" => true,
				],
				[
					"label" => "2",
					"url" => url("?page=2"),
					"active" => false,
				],
				[
					"label" => "3",
					"url" => url("?page=3"),
					"active" => false,
				],
				[
					"label" => "4",
					"url" => url("?page=4"),
					"active" => false,
				],
			]);

		expect(
			$generatePaginationLinksAction->execute(
				currentPageIndex: 0,
				perPage: 1,
				totalCount: 50
			)
		)
			->toHaveKey("previousPageUrl", null)
			->toHaveKey("nextPageUrl", url("?page=2"))
			->toHaveKey("links", [
				[
					"label" => "1",
					"url" => url("?page=1"),
					"active" => true,
				],
				[
					"label" => "2",
					"url" => url("?page=2"),
					"active" => false,
				],
				[
					"label" => "3",
					"url" => url("?page=3"),
					"active" => false,
				],
				[
					"label" => "4",
					"url" => url("?page=4"),
					"active" => false,
				],
				[
					"label" => "5",
					"url" => url("?page=5"),
					"active" => false,
				],
			]);
	}
);

it("should generate pagination links correctly when in last page", function () {
	$generatePaginationLinksAction = app(GeneratePaginationLinksAction::class);

	expect(
		$generatePaginationLinksAction->execute(
			currentPageIndex: 9,
			perPage: 5,
			totalCount: 50
		)
	)
		->toHaveKey("previousPageUrl", url("?page=9"))
		->toHaveKey("nextPageUrl", null)
		->toHaveKey("links", [
			[
				"label" => "6",
				"url" => url("?page=6"),
				"active" => false,
			],
			[
				"label" => "7",
				"url" => url("?page=7"),
				"active" => false,
			],
			[
				"label" => "8",
				"url" => url("?page=8"),
				"active" => false,
			],
			[
				"label" => "9",
				"url" => url("?page=9"),
				"active" => false,
			],
			[
				"label" => "10",
				"url" => url("?page=10"),
				"active" => true,
			],
		]);

	expect(
		$generatePaginationLinksAction->execute(
			currentPageIndex: 3,
			perPage: 15,
			totalCount: 50
		)
	)
		->toHaveKey("previousPageUrl", url("?page=3"))
		->toHaveKey("nextPageUrl", null)
		->toHaveKey("links", [
			[
				"label" => "1",
				"url" => url("?page=1"),
				"active" => false,
			],
			[
				"label" => "2",
				"url" => url("?page=2"),
				"active" => false,
			],
			[
				"label" => "3",
				"url" => url("?page=3"),
				"active" => false,
			],
			[
				"label" => "4",
				"url" => url("?page=4"),
				"active" => true,
			],
		]);

	expect(
		$generatePaginationLinksAction->execute(
			currentPageIndex: 2,
			perPage: 20,
			totalCount: 50
		)
	)
		->toHaveKey("previousPageUrl", url("?page=2"))
		->toHaveKey("nextPageUrl", null)
		->toHaveKey("links", [
			[
				"label" => "1",
				"url" => url("?page=1"),
				"active" => false,
			],
			[
				"label" => "2",
				"url" => url("?page=2"),
				"active" => false,
			],
			[
				"label" => "3",
				"url" => url("?page=3"),
				"active" => true,
			],
		]);
});

it(
	"should generate pagination links correctly when going from last page",
	function () {
		$generatePaginationLinksAction = app(
			GeneratePaginationLinksAction::class
		);

		expect(
			$generatePaginationLinksAction->execute(
				currentPageIndex: 8,
				perPage: 5,
				totalCount: 50
			)
		)
			->toHaveKey("previousPageUrl", url("?page=8"))
			->toHaveKey("nextPageUrl", url("?page=10"))
			->toHaveKey("links", [
				[
					"label" => "6",
					"url" => url("?page=6"),
					"active" => false,
				],
				[
					"label" => "7",
					"url" => url("?page=7"),
					"active" => false,
				],
				[
					"label" => "8",
					"url" => url("?page=8"),
					"active" => false,
				],
				[
					"label" => "9",
					"url" => url("?page=9"),
					"active" => true,
				],
				[
					"label" => "10",
					"url" => url("?page=10"),
					"active" => false,
				],
			]);

		expect(
			$generatePaginationLinksAction->execute(
				currentPageIndex: 7,
				perPage: 5,
				totalCount: 50
			)
		)
			->toHaveKey("previousPageUrl", url("?page=7"))
			->toHaveKey("nextPageUrl", url("?page=9"))
			->toHaveKey("links", [
				[
					"label" => "6",
					"url" => url("?page=6"),
					"active" => false,
				],
				[
					"label" => "7",
					"url" => url("?page=7"),
					"active" => false,
				],
				[
					"label" => "8",
					"url" => url("?page=8"),
					"active" => true,
				],
				[
					"label" => "9",
					"url" => url("?page=9"),
					"active" => false,
				],
				[
					"label" => "10",
					"url" => url("?page=10"),
					"active" => false,
				],
			]);

		expect(
			$generatePaginationLinksAction->execute(
				currentPageIndex: 6,
				perPage: 5,
				totalCount: 50
			)
		)
			->toHaveKey("previousPageUrl", url("?page=6"))
			->toHaveKey("nextPageUrl", url("?page=8"))
			->toHaveKey("links", [
				[
					"label" => "5",
					"url" => url("?page=5"),
					"active" => false,
				],
				[
					"label" => "6",
					"url" => url("?page=6"),
					"active" => false,
				],
				[
					"label" => "7",
					"url" => url("?page=7"),
					"active" => true,
				],
				[
					"label" => "8",
					"url" => url("?page=8"),
					"active" => false,
				],
				[
					"label" => "9",
					"url" => url("?page=9"),
					"active" => false,
				],
			]);
	}
);

it(
	"should generate pagination links correctly when going from first page",
	function () {
		$generatePaginationLinksAction = app(
			GeneratePaginationLinksAction::class
		);

		expect(
			$generatePaginationLinksAction->execute(
				currentPageIndex: 1,
				perPage: 5,
				totalCount: 50
			)
		)
			->toHaveKey("previousPageUrl", url("?page=1"))
			->toHaveKey("nextPageUrl", url("?page=3"))
			->toHaveKey("links", [
				[
					"label" => "1",
					"url" => url("?page=1"),
					"active" => false,
				],
				[
					"label" => "2",
					"url" => url("?page=2"),
					"active" => true,
				],
				[
					"label" => "3",
					"url" => url("?page=3"),
					"active" => false,
				],
				[
					"label" => "4",
					"url" => url("?page=4"),
					"active" => false,
				],
				[
					"label" => "5",
					"url" => url("?page=5"),
					"active" => false,
				],
			]);

		expect(
			$generatePaginationLinksAction->execute(
				currentPageIndex: 2,
				perPage: 5,
				totalCount: 50
			)
		)
			->toHaveKey("previousPageUrl", url("?page=2"))
			->toHaveKey("nextPageUrl", url("?page=4"))
			->toHaveKey("links", [
				[
					"label" => "1",
					"url" => url("?page=1"),
					"active" => false,
				],
				[
					"label" => "2",
					"url" => url("?page=2"),
					"active" => false,
				],
				[
					"label" => "3",
					"url" => url("?page=3"),
					"active" => true,
				],
				[
					"label" => "4",
					"url" => url("?page=4"),
					"active" => false,
				],
				[
					"label" => "5",
					"url" => url("?page=5"),
					"active" => false,
				],
			]);

		expect(
			$generatePaginationLinksAction->execute(
				currentPageIndex: 3,
				perPage: 5,
				totalCount: 50
			)
		)
			->toHaveKey("previousPageUrl", url("?page=3"))
			->toHaveKey("nextPageUrl", url("?page=5"))
			->toHaveKey("links", [
				[
					"label" => "2",
					"url" => url("?page=2"),
					"active" => false,
				],
				[
					"label" => "3",
					"url" => url("?page=3"),
					"active" => false,
				],
				[
					"label" => "4",
					"url" => url("?page=4"),
					"active" => true,
				],
				[
					"label" => "5",
					"url" => url("?page=5"),
					"active" => false,
				],
				[
					"label" => "6",
					"url" => url("?page=6"),
					"active" => false,
				],
			]);
	}
);
