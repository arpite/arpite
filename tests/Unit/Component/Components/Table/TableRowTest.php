<?php

namespace Arpite\Tests\Unit\Component\Components\Table;

use Arpite\Component\Components\Table\TableRow;
use Arpite\Tests\TestCase;
use Arpite\Tests\Unit\Component\TestComponent;

class TableRowTest extends TestCase
{
	public function test_initial_state(): void
	{
		$testTableRow = TableRow::make("uuid");

		$this->assertEquals(
			[
				"nodeType" => "TableRow",
				"id" => "uuid",
				"values" => [],
			],
			$testTableRow->export()
		);
	}

	public function test_set_id(): void
	{
		$testTableRow = TableRow::make("this-is-uuid");

		$this->assertEquals(
			[
				"nodeType" => "TableRow",
				"id" => "this-is-uuid",
				"values" => [],
			],
			$testTableRow->export()
		);
	}

	public function test_set_values(): void
	{
		$testTableRow = TableRow::make("uuid")->setValues([
			"Rot",
			"Pop",
			"High",
		]);

		$this->assertEquals(
			[
				"nodeType" => "TableRow",
				"id" => "uuid",
				"values" => ["Rot", "Pop", "High"],
			],
			$testTableRow->export()
		);
	}

	public function test_set_values_with_nodes(): void
	{
		$testTableRow = TableRow::make("uuid")->setValues([
			"Rot",
			new TestComponent(),
			"High",
		]);

		$this->assertEquals(
			[
				"nodeType" => "TableRow",
				"id" => "uuid",
				"values" => ["Rot", ["nodeType" => "TestComponent"], "High"],
			],
			$testTableRow->export()
		);
	}
}
