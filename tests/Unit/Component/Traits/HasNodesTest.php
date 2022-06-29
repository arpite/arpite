<?php

namespace Arpite\Tests\Unit\Component\Traits;

use Arpite\Tests\TestCase;
use Arpite\Tests\Unit\Component\TestComponent;

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
