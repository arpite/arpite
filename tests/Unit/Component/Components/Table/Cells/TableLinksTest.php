<?php

namespace Arpite\Arpite\Tests\Unit\Component\Components\Table\Cells;

use Arpite\Arpite\Component\Components\Table\Cells\TableLinks;
use Arpite\Arpite\Tests\TestCase;

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
