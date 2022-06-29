<?php

namespace Arpite\Tests\Unit\Component\Components\PaginatedTable;

use Arpite\Component\Components\PaginatedTable\PaginatedTable;
use Arpite\Component\Components\Table\TableRow;
use Domain\Team\Models\User;
use Exception;
use Arpite\Tests\TestCase;
use Arpite\Tests\Unit\Component\TestComponent;

class PaginatedTableTest extends TestCase
{
	private function createDummyUsers(): void
	{
		User::factory()->createMany([
			[
				"name" => "Name1",
				"email" => "Email1",
			],
			[
				"name" => "Name2",
				"email" => "Email2",
			],
			[
				"name" => "Name3",
				"email" => "Email3",
			],
		]);
	}

	/**
	 * @throws Exception
	 */
	public function test_should_throw_an_exception_when_query_is_not_set(): void
	{
		$testPaginatedTable = PaginatedTable::make();

		$this->expectExceptionMessage(
			'Query must be set for PaginatedTable. Use "setQuery" method'
		);

		$testPaginatedTable->export();
	}

	/**
	 * @throws Exception
	 */
	public function test_should_throw_an_exception_when_row_function_is_not_set(): void
	{
		$testPaginatedTable = PaginatedTable::make()->setQuery(
			User::select("name", "email")
		);

		$this->createDummyUsers();

		$this->expectExceptionMessage(
			'Row function must be set for PaginatedTable. Use "setRow" method.'
		);

		$testPaginatedTable->export();
	}

	/**
	 * @throws Exception
	 */
	public function test_should_have_rows_with_values(): void
	{
		$testPaginatedTable = PaginatedTable::make()
			->withoutPanel()
			->setQuery(User::select("name", "email"))
			->addColumn("Name")
			->addColumn("Email")
			->setRow(
				fn(User $user) => TableRow::make($user->name)->setValues([
					"name" => $user->name,
					"email" => $user->email,
				])
			);

		$this->createDummyUsers();

		$this->assertEquals(
			[
				"nodeType" => "PaginatedTable",
				"columns" => [
					[
						"title" => "Name",
						"identifier" => "name",
					],
					[
						"title" => "Email",
						"identifier" => "email",
					],
				],
				"rows" => [
					[
						"nodeType" => "TableRow",
						"id" => "Name1",
						"values" => ["Name1", "Email1"],
					],
					[
						"nodeType" => "TableRow",
						"id" => "Name2",
						"values" => ["Name2", "Email2"],
					],
					[
						"nodeType" => "TableRow",
						"id" => "Name3",
						"values" => ["Name3", "Email3"],
					],
				],
				"widths" => [],
				"asPairTable" => false,
				"emptyState" => null,
				"total" => 3,
				"from" => 1,
				"to" => 3,
				"links" => [
					[
						"active" => true,
						"label" => "1",
						"url" => config("app.url") . "?page=1",
					],
				],
				"previousPageUrl" => null,
				"nextPageUrl" => null,
				"actions" => [],
			],
			$testPaginatedTable->export()
		);
	}

	/**
	 * @throws Exception
	 */
	public function test_should_set_column_custom_identifier(): void
	{
		$testPaginatedTable = PaginatedTable::make()
			->withoutPanel()
			->setQuery(User::select("name", "email"))
			->addColumn("Name")
			->addColumn("Information", "email")
			->setRow(
				fn(User $user) => TableRow::make($user->name)->setValues([
					"name" => $user->name,
					"email" => $user->email,
				])
			);

		$this->createDummyUsers();

		$this->assertEquals(
			[
				"nodeType" => "PaginatedTable",
				"columns" => [
					[
						"title" => "Name",
						"identifier" => "name",
					],
					[
						"title" => "Information",
						"identifier" => "email",
					],
				],
				"rows" => [
					[
						"nodeType" => "TableRow",
						"id" => "Name1",
						"values" => ["Name1", "Email1"],
					],
					[
						"nodeType" => "TableRow",
						"id" => "Name2",
						"values" => ["Name2", "Email2"],
					],
					[
						"nodeType" => "TableRow",
						"id" => "Name3",
						"values" => ["Name3", "Email3"],
					],
				],
				"widths" => [],
				"asPairTable" => false,
				"emptyState" => null,
				"total" => 3,
				"from" => 1,
				"to" => 3,
				"links" => [
					[
						"active" => true,
						"label" => "1",
						"url" => config("app.url") . "?page=1",
					],
				],
				"previousPageUrl" => null,
				"nextPageUrl" => null,
				"actions" => [],
			],
			$testPaginatedTable->export()
		);
	}

	/**
	 * @throws Exception
	 */
	public function test_set_per_page(): void
	{
		$testPaginatedTable = PaginatedTable::make()
			->withoutPanel()
			->setQuery(User::select("name", "email"))
			->setRow(
				fn(User $user) => TableRow::make($user->name)->setValues([
					"email" => $user->email,
				])
			)
			->setPerPage(1);

		$this->createDummyUsers();

		$this->assertEquals(
			[
				"nodeType" => "PaginatedTable",
				"columns" => [],
				"rows" => [
					[
						"nodeType" => "TableRow",
						"id" => "Name1",
						"values" => ["Email1"],
					],
				],
				"widths" => [],
				"asPairTable" => false,
				"emptyState" => null,
				"total" => 3,
				"from" => 1,
				"to" => 1,
				"links" => [
					[
						"active" => true,
						"label" => "1",
						"url" => config("app.url") . "?page=1",
					],
					[
						"active" => false,
						"label" => "2",
						"url" => config("app.url") . "?page=2",
					],
					[
						"active" => false,
						"label" => "3",
						"url" => config("app.url") . "?page=3",
					],
				],
				"previousPageUrl" => null,
				"nextPageUrl" => config("app.url") . "?page=2",
				"actions" => [],
			],
			$testPaginatedTable->export()
		);
	}

	/**
	 * @throws Exception
	 */
	public function test_should_have_exported_row_value(): void
	{
		$testPaginatedTable = PaginatedTable::make()
			->setQuery(User::select("name", "email"))
			->addColumn(null, "view")
			->setRow(
				fn(User $user) => TableRow::make($user->name)->setValues([
					"view" => new TestComponent(),
				])
			);

		$this->createDummyUsers();

		$this->assertEquals(
			[
				"nodeType" => "Panel",
				"nodes" => [
					[
						"nodeType" => "PaginatedTable",
						"columns" => [
							[
								"title" => "",
								"identifier" => "view",
							],
						],
						"rows" => [
							[
								"nodeType" => "TableRow",
								"id" => "Name1",
								"values" => [["nodeType" => "TestComponent"]],
							],
							[
								"nodeType" => "TableRow",
								"id" => "Name2",
								"values" => [["nodeType" => "TestComponent"]],
							],
							[
								"nodeType" => "TableRow",
								"id" => "Name3",
								"values" => [["nodeType" => "TestComponent"]],
							],
						],
						"widths" => [],
						"asPairTable" => false,
						"emptyState" => null,
						"total" => 3,
						"from" => 1,
						"to" => 3,
						"links" => [
							[
								"active" => true,
								"label" => "1",
								"url" => config("app.url") . "?page=1",
							],
						],
						"previousPageUrl" => null,
						"nextPageUrl" => null,
						"actions" => [],
					],
				],
				"actions" => [],
				"title" => null,
				"description" => null,
				"padding" => 6,
			],
			$testPaginatedTable->export()
		);
	}
}
