<?php

namespace SudoBee\Cygnus\Tests\Unit\Component\Components\Table;

use SudoBee\Cygnus\Component\Components\EmptyState;
use SudoBee\Cygnus\Component\Components\Table\Table;
use SudoBee\Cygnus\Component\Components\Table\TableRow;
use SudoBee\Cygnus\Tests\Constants;
use SudoBee\Cygnus\Tests\TestCase;
use SudoBee\Cygnus\Tests\Unit\Component\TestComponent;

class TableTest extends TestCase
{
	public function test_initial_state(): void
	{
		$testTable = Table::make()->withoutPanel();

		$this->assertEquals(
			[
				"nodeType" => "Table",
				"columns" => [],
				"rows" => [],
				"widths" => [],
				"asPairTable" => false,
				"emptyState" => null,
				"actions" => [],
			],
			$testTable->export()
		);
	}

	public function test_add_column(): void
	{
		$testTable = Table::make()
			->withoutPanel()
			->addColumn("First name")
			->addColumn("Second");

		$this->assertEquals(
			[
				"nodeType" => "Table",
				"columns" => [
					["title" => "First name", "identifier" => "first-name"],
					["title" => "Second", "identifier" => "second"],
				],
				"rows" => [],
				"widths" => [],
				"asPairTable" => false,
				"emptyState" => null,
				"actions" => [],
			],
			$testTable->export()
		);
	}

	public function test_add_links_button(): void
	{
		$testTable = Table::make()
			->withoutPanel()
			->addLinksColumn();

		$this->assertEquals(
			[
				"nodeType" => "Table",
				"columns" => [["title" => "", "identifier" => "links"]],
				"rows" => [],
				"widths" => [],
				"asPairTable" => false,
				"emptyState" => null,
				"actions" => [],
			],
			$testTable->export()
		);
	}

	public function test_set_column_custom_identifier(): void
	{
		$testTable = Table::make()
			->withoutPanel()
			->addColumn("First name")
			->addColumn("Second", "very-second")
			->addColumn(null, "view");

		$this->assertEquals(
			[
				"nodeType" => "Table",
				"columns" => [
					["title" => "First name", "identifier" => "first-name"],
					["title" => "Second", "identifier" => "very-second"],
					["title" => "", "identifier" => "view"],
				],
				"rows" => [],
				"widths" => [],
				"asPairTable" => false,
				"emptyState" => null,
				"actions" => [],
			],
			$testTable->export()
		);
	}

	public function test_set_rows_with_array(): void
	{
		$testTable = Table::make()
			->withoutPanel()
			->setRows([
				TableRow::make("row1")->setValues(["Tom", "Josh"]),
				TableRow::make("row2")->setValues(["Brit", "Good Er"]),
				TableRow::make("row3")->setValues(["Tommy", "Bunny"]),
			]);

		$this->assertEquals(
			[
				"nodeType" => "Table",
				"columns" => [],
				"rows" => [
					[
						"nodeType" => "TableRow",
						"id" => "row1",
						"values" => ["Tom", "Josh"],
					],
					[
						"nodeType" => "TableRow",
						"id" => "row2",
						"values" => ["Brit", "Good Er"],
					],
					[
						"nodeType" => "TableRow",
						"id" => "row3",
						"values" => ["Tommy", "Bunny"],
					],
				],
				"widths" => [],
				"asPairTable" => false,
				"emptyState" => null,
				"actions" => [],
			],
			$testTable->export()
		);
	}

	public function test_set_rows_with_class(): void
	{
		$testTable = Table::make()
			->withoutPanel()
			->setRows([
				TableRow::make("uuid")->setValues(["Brit", "Good Er"]),
				TableRow::make("uuid")->setValues(["Root", "Attack"]),
			]);

		$this->assertEquals(
			[
				"nodeType" => "Table",
				"columns" => [],
				"rows" => [
					[
						"nodeType" => "TableRow",
						"id" => "uuid",
						"values" => ["Brit", "Good Er"],
					],
					[
						"nodeType" => "TableRow",
						"id" => "uuid",
						"values" => ["Root", "Attack"],
					],
				],
				"widths" => [],
				"asPairTable" => false,
				"emptyState" => null,
				"actions" => [],
			],
			$testTable->export()
		);
	}

	public function test_add_row(): void
	{
		$testTable = Table::make()
			->withoutPanel()
			->addRow(TableRow::make("row1")->setValues(["Brit", "Good Er"]))
			->addRow(TableRow::make("row2")->setValues(["Tommy", "Bunny"]));

		$this->assertEquals(
			[
				"nodeType" => "Table",
				"columns" => [],
				"rows" => [
					[
						"nodeType" => "TableRow",
						"id" => "row1",
						"values" => ["Brit", "Good Er"],
					],
					[
						"nodeType" => "TableRow",
						"id" => "row2",
						"values" => ["Tommy", "Bunny"],
					],
				],
				"widths" => [],
				"asPairTable" => false,
				"emptyState" => null,
				"actions" => [],
			],
			$testTable->export()
		);
	}

	public function test_set_widths(): void
	{
		$testTable = Table::make()
			->withoutPanel()
			->setWidths(50, 20, 10);

		$this->assertEquals(
			[
				"nodeType" => "Table",
				"columns" => [],
				"rows" => [],
				"widths" => [62.5, 25, 12.5],
				"asPairTable" => false,
				"emptyState" => null,
				"actions" => [],
			],
			$testTable->export()
		);
	}

	public function test_set_custom_empty_state(): void
	{
		$testTable = Table::make()
			->withoutPanel()
			->setEmptyState(EmptyState::make());

		$this->assertEquals(
			[
				"nodeType" => "Table",
				"columns" => [],
				"rows" => [],
				"widths" => [],
				"asPairTable" => false,
				"emptyState" => [
					"nodeType" => "EmptyState",
					"title" => null,
					"description" => null,
					"buttons" => [],
					"image" => null,
				],
				"actions" => [],
			],
			$testTable->export()
		);
	}

	public function test_set_custom_empty_state_from_callback(): void
	{
		$testTable = Table::make()
			->withoutPanel()
			->setEmptyState(fn() => EmptyState::make());

		$this->assertEquals(
			[
				"nodeType" => "Table",
				"columns" => [],
				"rows" => [],
				"widths" => [],
				"asPairTable" => false,
				"emptyState" => [
					"nodeType" => "EmptyState",
					"title" => null,
					"description" => null,
					"buttons" => [],
					"image" => null,
				],
				"actions" => [],
			],
			$testTable->export()
		);
	}

	public function test_set_panel_actions(): void
	{
		$testTable = Table::make()->setPanelActions([new TestComponent()]);

		$this->assertEquals(
			[
				"nodeType" => "Panel",
				"nodes" => [
					[
						"nodeType" => "Table",
						"columns" => [],
						"rows" => [],
						"widths" => [],
						"asPairTable" => false,
						"emptyState" => null,
						"actions" => [],
					],
				],
				"actions" => [Constants::testComponent()],
				"title" => null,
				"description" => null,
				"padding" => 6,
			],
			$testTable->export()
		);
	}

	public function test_as_pair_table(): void
	{
		$testTable = Table::make()->withoutPanel();

		$this->assertEquals(
			[
				"nodeType" => "Table",
				"columns" => [],
				"rows" => [],
				"widths" => [],
				"asPairTable" => false,
				"emptyState" => null,
				"actions" => [],
			],
			$testTable->export()
		);

		$testTable->asPairTable();
		$this->assertEquals(
			[
				"nodeType" => "Table",
				"columns" => [],
				"rows" => [],
				"widths" => [],
				"asPairTable" => true,
				"emptyState" => null,
				"actions" => [],
			],
			$testTable->export()
		);

		$testTable->asPairTable(false);
		$this->assertEquals(
			[
				"nodeType" => "Table",
				"columns" => [],
				"rows" => [],
				"widths" => [],
				"asPairTable" => false,
				"emptyState" => null,
				"actions" => [],
			],
			$testTable->export()
		);
	}

	public function test_all_combined(): void
	{
		$testTable = Table::make()
			->withoutPanel()
			->addColumn("First name")
			->addColumn("Second")
			->addColumn("Age")
			->addLinksColumn()
			->setWidths(20, 30, 40)
			->setRows([
				TableRow::make("row1")->setValues(["Tom", "Josh", 25]),
				TableRow::make("row2")->setValues(["Brit", "Good Er", 14]),
				TableRow::make("row3")->setValues(["Tommy", "Bunny", 34]),
			])
			->setEmptyState(EmptyState::make());

		$this->assertEquals(
			[
				"nodeType" => "Table",
				"columns" => [
					["title" => "First name", "identifier" => "first-name"],
					["title" => "Second", "identifier" => "second"],
					["title" => "Age", "identifier" => "age"],
					["title" => "", "identifier" => "links"],
				],
				"rows" => [
					[
						"nodeType" => "TableRow",
						"id" => "row1",
						"values" => ["Tom", "Josh", 25],
					],
					[
						"nodeType" => "TableRow",
						"id" => "row2",
						"values" => ["Brit", "Good Er", 14],
					],
					[
						"nodeType" => "TableRow",
						"id" => "row3",
						"values" => ["Tommy", "Bunny", 34],
					],
				],
				"widths" => [22.22, 33.33, 44.44],
				"asPairTable" => false,
				"emptyState" => [
					"nodeType" => "EmptyState",
					"title" => null,
					"description" => null,
					"buttons" => [],
					"image" => null,
				],
				"actions" => [],
			],
			$testTable->export()
		);
	}
}
