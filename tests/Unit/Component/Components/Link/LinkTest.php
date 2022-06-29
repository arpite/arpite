<?php

namespace Arpite\Tests\Unit\Component\Components\Link;

use Arpite\Component\Components\Link\Link;
use Exception;
use Arpite\Tests\TestCase;

class LinkTest extends TestCase
{
	/**
	 * @throws Exception
	 */
	public function test_initial_state(): void
	{
		$testLink = Link::make();

		$this->assertEquals(
			[
				"nodeType" => "Link",
				"title" => null,
				"link" => null,
				"action" => null,
				"nodesAction" => null,
				"actionAlert" => null,
				"color" => "primary",
				"modal" => null,
				"type" => "button",
				"blank" => false,
				"textAlign" => null,
			],
			$testLink->export()
		);
	}
}
