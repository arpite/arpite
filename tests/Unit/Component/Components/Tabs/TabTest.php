<?php

namespace SudoBee\Cygnus\Tests\Unit\Component\Components\Tabs;

use SudoBee\Cygnus\Component\Components\Tabs\Tab;
use SudoBee\Cygnus\Tests\TestCase;
use SudoBee\Cygnus\Tests\Unit\Component\TestComponent;

class TabTest extends TestCase
{
	public function test_initial_state(): void
	{
		$testTab = Tab::make("First");

		$this->assertEquals(
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
			$testTab->export()
		);
	}

	public function test_set_icon(): void
	{
		$testTab = Tab::make("First")->setIcon("car-icon-svg");

		$this->assertEquals(
			[
				"nodeType" => "Tab",
				"title" => "First",
				"icon" => "car-icon-svg",
				"count" => null,
				"nodes" => [],
				"actions" => [],
				"link" => null,
				"primary" => false,
			],
			$testTab->export()
		);
	}

	public function test_set_count(): void
	{
		$testTab = Tab::make("First")->setCount(6);

		$this->assertEquals(
			[
				"nodeType" => "Tab",
				"title" => "First",
				"icon" => null,
				"count" => 6,
				"nodes" => [],
				"actions" => [],
				"link" => null,
				"primary" => false,
			],
			$testTab->export()
		);
	}

	public function test_set_actions(): void
	{
		$testTab = Tab::make("First")->setActions([
			new TestComponent(),
			new TestComponent(),
		]);

		$this->assertEquals(
			[
				"nodeType" => "Tab",
				"title" => "First",
				"icon" => null,
				"count" => null,
				"nodes" => [],
				"actions" => [
					["nodeType" => "TestComponent"],
					["nodeType" => "TestComponent"],
				],
				"link" => null,
				"primary" => false,
			],
			$testTab->export()
		);
	}

	public function test_set_link(): void
	{
		$testTab = Tab::make("First")->setLink("/link");

		$this->assertEquals(
			[
				"nodeType" => "Tab",
				"title" => "First",
				"icon" => null,
				"count" => null,
				"nodes" => [],
				"actions" => [],
				"link" => "/link",
				"primary" => false,
			],
			$testTab->export()
		);
	}

	public function test_is_primary(): void
	{
		$testTab = Tab::make("First")->isPrimary();

		$this->assertEquals(
			[
				"nodeType" => "Tab",
				"title" => "First",
				"icon" => null,
				"count" => null,
				"nodes" => [],
				"actions" => [],
				"link" => null,
				"primary" => true,
			],
			$testTab->export()
		);
	}

	public function test_all_combined(): void
	{
		$testTab = Tab::make("First")
			->setNodes([new TestComponent(), new TestComponent()])
			->setCount(6)
			->setIcon("cat-icon-svg")
			->setActions([new TestComponent()]);

		$this->assertEquals(
			[
				"nodeType" => "Tab",
				"title" => "First",
				"icon" => "cat-icon-svg",
				"count" => 6,
				"nodes" => [
					["nodeType" => "TestComponent"],
					["nodeType" => "TestComponent"],
				],
				"actions" => [["nodeType" => "TestComponent"]],
				"link" => null,
				"primary" => false,
			],
			$testTab->export()
		);
	}
}
