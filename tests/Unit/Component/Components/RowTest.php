<?php

namespace SudoBee\Cygnus\Tests\Unit\Component\Components;

use SudoBee\Cygnus\Component\Components\Row;
use SudoBee\Cygnus\Tests\TestCase;

class RowTest extends TestCase
{
	public function test_initial_state(): void
	{
		$testRow = Row::make();

		$this->assertEquals(
			[
				"nodeType" => "Row",
				"nodes" => [],
				"gap" => 0,
			],
			$testRow->export()
		);
	}
}
