<?php

namespace Arpite\Tests\Unit\Component\Components\Table\Cells;

use Arpite\Component\Components\Table\Cells\TableLinks;
use Arpite\Tests\TestCase;

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
