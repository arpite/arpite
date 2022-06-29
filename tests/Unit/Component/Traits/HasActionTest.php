<?php

namespace Arpite\Tests\Unit\Component\Traits;

use Arpite\Tests\TestCase;

class HasActionTest extends TestCase
{
	public function test_initial_state(): void
	{
		$testComponent = new TestComponentWithHasActionTrait();

		$this->assertEquals(
			[
				"nodeType" => "TestComponentWithHasActionTrait",
				"action" => null,
			],
			$testComponent->export()
		);
	}

	public function test_set_action(): void
	{
		$testComponent = new TestComponentWithHasActionTrait();

		$testComponent->setAction("/posts/498489/delete");

		$this->assertEquals(
			[
				"nodeType" => "TestComponentWithHasActionTrait",
				"action" => "/posts/498489/delete",
			],
			$testComponent->export()
		);
	}

	public function test_all_combined(): void
	{
		$testComponent = new TestComponentWithHasActionTrait();

		$testComponent->setAction("/posts/987987987/delete");

		$this->assertEquals(
			[
				"nodeType" => "TestComponentWithHasActionTrait",
				"action" => "/posts/987987987/delete",
			],
			$testComponent->export()
		);
	}
}
