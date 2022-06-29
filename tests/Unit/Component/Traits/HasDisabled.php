<?php

namespace Arpite\Tests\Unit\Component\Traits;

use Arpite\Tests\TestCase;

class HasDisabled extends TestCase
{
	public function test_initial_state(): void
	{
		$testComponent = new TestComponentWithHasDisabledTrait();

		$this->assertEquals(
			[
				"nodeType" => "TestComponentWithHasDisabledTrait",
				"disabled" => false,
			],
			$testComponent->export()
		);
	}

	public function test_set_disabled(): void
	{
		$testComponent = new TestComponentWithHasDisabledTrait();

		$testComponent->setDisabled();
		$this->assertEquals(
			[
				"nodeType" => "TestComponentWithHasGapTrait",
				"disabled" => true,
			],
			$testComponent->export()
		);

		$testComponent->setDisabled(false);
		$this->assertEquals(
			[
				"nodeType" => "TestComponentWithHasGapTrait",
				"disabled" => false,
			],
			$testComponent->export()
		);
	}
}
