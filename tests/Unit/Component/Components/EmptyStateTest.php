<?php

namespace Arpite\Tests\Unit\Component\Components;

use Arpite\Component\Components\EmptyState;
use Arpite\Tests\TestCase;

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
