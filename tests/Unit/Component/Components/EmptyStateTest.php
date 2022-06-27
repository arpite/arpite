<?php

namespace SudoBee\Cygnus\Tests\Unit\Component\Components;

use SudoBee\Cygnus\Component\Components\EmptyState;
use SudoBee\Cygnus\Tests\TestCase;

class EmptyStateTest extends TestCase
{
	public function test_initial_state(): void
	{
		$testEmptyState = EmptyState::make();

		$this->assertEquals(
			[
				"nodeType" => "EmptyState",
				"title" => null,
				"description" => null,
				"buttons" => [],
				"image" => null,
			],
			$testEmptyState->export()
		);
	}
}
