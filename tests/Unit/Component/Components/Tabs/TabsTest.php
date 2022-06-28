<?php

namespace Arpite\Arpite\Tests\Unit\Component\Components\Tabs;

use Arpite\Arpite\Component\Components\Tabs\Enums\TabsDesign;
use Arpite\Arpite\Component\Components\Tabs\Tab;
use Arpite\Arpite\Component\Components\Tabs\Tabs;
use Arpite\Arpite\Tests\TestCase;

class TabsTest extends TestCase
{
	public function test_initial_state(): void
	{
		$testTabs = Tabs::make();

		$this->assertEquals(
			[
				"nodeType" => "Tabs",
				"tabs" => [],
				"design" => TabsDesign::REGULAR,
			],
			$testTabs->export()
		);
	}

	public function test_set_design(): void
	{
		$testTabs = Tabs::make()->setDesign(TabsDesign::SIDE);

		$this->assertEquals(
			[
				"nodeType" => "Tabs",
				"tabs" => [],
				"design" => TabsDesign::SIDE,
			],
			$testTabs->export()
		);
	}

	public function test_should_have_tabs(): void
	{
		$testTabs = Tabs::make()->setTabs([
			Tab::make("First"),
			Tab::make("Second"),
		]);

		$this->assertEquals(
			[
				"nodeType" => "Tabs",
				"tabs" => [
					[
						"nodeType" => "Tab",
						"title" => "First",
						"icon" => null,
						"count" => null,
						"nodes" => [],
						"actions" => [],
						"link" => null,
						"primary" => false,
					],
					[
						"nodeType" => "Tab",
						"title" => "Second",
						"icon" => null,
						"count" => null,
						"nodes" => [],
						"actions" => [],
						"link" => null,
						"primary" => false,
					],
				],
				"design" => TabsDesign::REGULAR,
			],
			$testTabs->export()
		);
	}

	public function test_all_combined(): void
	{
		$testTabs = Tabs::make();

		$testTabs->setTabs([Tab::make("The tab")])->setDesign(TabsDesign::SIDE);

		$this->assertEquals(
			[
				"nodeType" => "Tabs",
				"tabs" => [
					[
						"nodeType" => "Tab",
						"title" => "The tab",
						"icon" => null,
						"count" => null,
						"nodes" => [],
						"actions" => [],
						"link" => null,
						"primary" => false,
					],
				],
				"design" => TabsDesign::SIDE,
			],
			$testTabs->export()
		);
	}
}
