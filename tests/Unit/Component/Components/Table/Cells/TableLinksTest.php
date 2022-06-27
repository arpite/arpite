<?php

namespace SudoBee\Cygnus\Tests\Unit\Component\Components\Table\Cells;

use SudoBee\Cygnus\Component\Components\Table\Cells\TableLinks;
use SudoBee\Cygnus\Tests\TestCase;

class TableLinksTest extends TestCase
{
	public function test_initial_state(): void
	{
		$testTableLinks = TableLinks::make();

		$this->assertEquals(
			[
				"nodeType" => "TableLinks",
				"nodes" => [],
			],
			$testTableLinks->export()
		);
	}
}
