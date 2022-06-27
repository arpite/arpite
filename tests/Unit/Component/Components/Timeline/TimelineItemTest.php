<?php

namespace SudoBee\Cygnus\Tests\Unit\Component\Components\Timeline;

use Carbon\CarbonImmutable;
use SudoBee\Cygnus\Component\Components\Timeline\TimelineItem;
use SudoBee\Cygnus\Tests\TestCase;

class TimelineItemTest extends TestCase
{
	public function test_initial_state(): void
	{
		$node = TimelineItem::make();

		$this->assertEquals(
			[
				"nodeType" => "TimelineItem",
				"title" => null,
				"description" => null,
				"date" => null,
			],
			$node->export()
		);
	}

	public function test_set_date(): void
	{
		$date = CarbonImmutable::create(2020, 01, 02, 10, 11, 22);

		$node = TimelineItem::make()->setDate($date);

		$this->assertEquals(
			[
				"nodeType" => "TimelineItem",
				"title" => null,
				"description" => null,
				"date" => $date,
			],
			$node->export()
		);
	}
}
