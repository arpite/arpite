<?php

namespace Arpite\Tests\Unit\Component\Traits;

use Arpite\Tests\TestCase;

class HasTitleTest extends TestCase
{
	public function test_initial_state(): void
	{
		$testComponent = new TestComponentWithHasTitleTrait();

		$this->assertEquals(
			[
				"nodeType" => "TestComponentWithHasTitleTrait",
				"title" => null,
			],
			$testComponent->export()
		);
	}

	public function test_set_title(): void
	{
		$testComponent = new TestComponentWithHasTitleTrait();

		$testComponent->setTitle("This is the new title");

		$this->assertEquals(
			[
				"nodeType" => "TestComponentWithHasTitleTrait",
				"title" => "This is the new title",
			],
			$testComponent->export()
		);
	}
}
