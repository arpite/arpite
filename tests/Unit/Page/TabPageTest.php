<?php

namespace SudoBee\Cygnus\Tests\Unit\Page;

use SudoBee\Cygnus\Tests\TestCase;

class TabPageTest extends TestCase
{
	public function test_tabs_data(): void
	{
		$page = new NewTestTab();

		$props = $this->getPrivateProperty($page->handleRequest(), "props");
		$tabs = $props["layoutProperties"]["tabs"];

		$this->assertCount(2, $tabs);

		$this->assertEquals(
			[
				[
					"title" => "New test",
					"icon" => "icon-svg-goes-here",
					"count" => null,
					"link" => "/test/new",
					"active" => true,
				],
				[
					"title" => "Very old test",
					"icon" => null,
					"count" => 10,
					"link" => "/test/very-old",
					"active" => false,
				],
			],
			$tabs
		);
	}
}
