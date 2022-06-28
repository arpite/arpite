<?php

namespace Arpite\Arpite\Tests\Unit\Component\Components;

use Arpite\Arpite\Component\Components\Tooltip\Tooltip;
use Arpite\Arpite\Tests\TestCase;

class TooltipTest extends TestCase
{
	public function test_initial_state(): void
	{
		$testTooltip = Tooltip::make();

		$this->assertEquals(
			[
				"nodeType" => "Tooltip",
				"content" => null,
				"placement" => "top",
				"nodes" => [],
			],
			$testTooltip->export()
		);
	}

	public function test_set_content(): void
	{
		$testTooltip = Tooltip::make()->setContent("Hi");

		$this->assertEquals(
			[
				"nodeType" => "Tooltip",
				"content" => "Hi",
				"placement" => "top",
				"nodes" => [],
			],
			$testTooltip->export()
		);
	}

	public function test_change_placement(): void
	{
		$testTooltip = Tooltip::make();

		$testTooltip->placementBottom();
		$this->assertEquals(
			[
				"nodeType" => "Tooltip",
				"content" => null,
				"placement" => "bottom",
				"nodes" => [],
			],
			$testTooltip->export()
		);

		$testTooltip->placementTop();
		$this->assertEquals(
			[
				"nodeType" => "Tooltip",
				"content" => null,
				"placement" => "top",
				"nodes" => [],
			],
			$testTooltip->export()
		);

		$testTooltip->placementLeft();
		$this->assertEquals(
			[
				"nodeType" => "Tooltip",
				"content" => null,
				"placement" => "left",
				"nodes" => [],
			],
			$testTooltip->export()
		);

		$testTooltip->placementRight();
		$this->assertEquals(
			[
				"nodeType" => "Tooltip",
				"content" => null,
				"placement" => "right",
				"nodes" => [],
			],
			$testTooltip->export()
		);
	}

	public function test_all_combined(): void
	{
		$testTooltip = Tooltip::make()
			->placementBottom()
			->setContent("BMW e36 M50B25 :)");

		$this->assertEquals(
			[
				"nodeType" => "Tooltip",
				"content" => "BMW e36 M50B25 :)",
				"placement" => "bottom",
				"nodes" => [],
			],
			$testTooltip->export()
		);
	}
}
