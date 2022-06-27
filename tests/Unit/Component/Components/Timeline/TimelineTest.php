<?php

namespace SudoBee\Cygnus\Tests\Unit\Component\Components\Timeline;

use SudoBee\Cygnus\Component\Components\Timeline\Timeline;
use SudoBee\Cygnus\Component\Components\Timeline\TimelineItem;
use SudoBee\Cygnus\Tests\TestCase;

class TimelineTest extends TestCase
{
	public function test_initial_state(): void
	{
		$node = Timeline::make();

		$this->assertEquals(
			[
				"nodeType" => "Timeline",
				"timelineItems" => [],
			],
			$node->export()
		);
	}

	public function test_set_timeline_items(): void
	{
		$node = Timeline::make()->setTimelineItems([
			TimelineItem::make(),
			TimelineItem::make(),
			TimelineItem::make(),
		]);

		$this->assertEquals(
			[
				"nodeType" => "Timeline",
				"timelineItems" => [
					[
						"nodeType" => "TimelineItem",
						"title" => null,
						"description" => null,
						"date" => null,
					],
					[
						"nodeType" => "TimelineItem",
						"title" => null,
						"description" => null,
						"date" => null,
					],
					[
						"nodeType" => "TimelineItem",
						"title" => null,
						"description" => null,
						"date" => null,
					],
				],
			],
			$node->export()
		);
	}
}
