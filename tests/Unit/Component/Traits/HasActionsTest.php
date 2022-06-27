<?php

namespace SudoBee\Cygnus\Tests\Unit\Component\Traits;

use SudoBee\Cygnus\Tests\TestCase;
use SudoBee\Cygnus\Tests\Unit\Component\TestComponent;

class HasActionsTest extends TestCase
{
	public function test_initial_state(): void
	{
		$testComponent = new TestComponentWithHasActionsTrait();

		$this->assertEquals(
			[
				"nodeType" => "TestComponentWithHasActionsTrait",
				"actions" => [],
			],
			$testComponent->export()
		);
	}

	public function test_set_actions(): void
	{
		$testComponent = new TestComponentWithHasActionsTrait();

		$testComponent->setActions([new TestComponent(), new TestComponent()]);

		$this->assertEquals(
			[
				"nodeType" => "TestComponentWithHasActionsTrait",
				"actions" => [
					["nodeType" => "TestComponent"],
					["nodeType" => "TestComponent"],
				],
			],
			$testComponent->export()
		);
	}
}
