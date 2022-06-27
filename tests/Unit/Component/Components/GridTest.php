<?php

namespace SudoBee\Cygnus\Tests\Unit\Component\Components;

use SudoBee\Cygnus\Component\Components\Grid;
use SudoBee\Cygnus\Tests\TestCase;
use SudoBee\Cygnus\Tests\Unit\Component\TestComponent;

class GridTest extends TestCase
{
	public function test_should_be_empty(): void
	{
		$testGrid = Grid::make();

		$this->assertEquals(
			[
				"nodeType" => "Grid",
				"columns" => ["d" => [1]],
				"nodes" => [],
				"gap" => 4,
			],
			$testGrid->export()
		);
	}

	public function test_set_columns(): void
	{
		$testGrid = Grid::make()->setColumns([1, 2]);

		$this->assertEquals(
			[
				"nodeType" => "Grid",
				"columns" => ["d" => [1, 2]],
				"nodes" => [],
				"gap" => 4,
			],
			$testGrid->export()
		);
	}

	public function test_all_combined(): void
	{
		$testGrid = Grid::make()
			->setColumns([4, 5, 4])
			->setNodes([
				new TestComponent(),
				new TestComponent(),
				new TestComponent(),
			]);

		$this->assertEquals(
			[
				"nodeType" => "Grid",
				"columns" => ["d" => [4, 5, 4]],
				"nodes" => [
					["nodeType" => "TestComponent"],
					["nodeType" => "TestComponent"],
					["nodeType" => "TestComponent"],
				],
				"gap" => 4,
			],
			$testGrid->export()
		);
	}
}
