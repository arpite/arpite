<?php

namespace Arpite\Arpite\Tests\Unit\Component\Traits;

use Arpite\Arpite\Tests\TestCase;

class HasGapTest extends TestCase
{
	public function test_initial_state(): void
	{
		$testComponent = new TestComponentWithHasGapTrait();

		$this->assertEquals(
			[
				"nodeType" => "TestComponentWithHasGapTrait",
				"gap" => 0,
			],
			$testComponent->export()
		);
	}

	public function test_set_gap(): void
	{
		$testComponent = new TestComponentWithHasGapTrait();

		$testComponent->setGap(5);

		$this->assertEquals(
			[
				"nodeType" => "TestComponentWithHasGapTrait",
				"gap" => 5,
			],
			$testComponent->export()
		);
	}
}
