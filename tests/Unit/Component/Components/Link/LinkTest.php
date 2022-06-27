<?php

namespace SudoBee\Cygnus\Tests\Unit\Component\Components\Link;

use SudoBee\Cygnus\Component\Components\Link\Link;
use Exception;
use SudoBee\Cygnus\Tests\TestCase;

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
