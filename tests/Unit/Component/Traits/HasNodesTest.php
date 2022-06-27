<?php

namespace SudoBee\Cygnus\Tests\Unit\Component\Traits;

use SudoBee\Cygnus\Tests\TestCase;
use SudoBee\Cygnus\Tests\Unit\Component\TestComponent;

class HasNodesTest extends TestCase
{
	public function test_initial_state(): void
	{
		$testComponent = new TestComponentWithHasNodesTrait();

		$this->assertEquals(
			[
				"nodeType" => "TestComponentWithHasNodesTrait",
				"nodes" => [],
			],
			$testComponent->export()
		);
	}

	public function test_set_nodes(): void
	{
		$testComponent = new TestComponentWithHasNodesTrait();

		$testComponent->setNodes([new TestComponent()]);

		$this->assertEquals(
			[
				"nodeType" => "TestComponentWithHasNodesTrait",
				"nodes" => [["nodeType" => "TestComponent"]],
			],
			$testComponent->export()
		);
	}
}
