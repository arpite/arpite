<?php

namespace Arpite\Arpite\Tests\Unit\Component\Components;

use Arpite\Arpite\Component\Components\Row;
use Arpite\Arpite\Tests\TestCase;

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
