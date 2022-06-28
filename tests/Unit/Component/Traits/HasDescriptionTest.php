<?php

namespace Arpite\Arpite\Tests\Unit\Component\Traits;

use Arpite\Arpite\Tests\TestCase;

class HasDescriptionTest extends TestCase
{
	public function test_initial_state(): void
	{
		$testComponent = new TestComponentWithHasDescriptionTrait();

		$this->assertEquals(
			[
				"nodeType" => "TestComponentWithHasDescriptionTrait",
				"description" => null,
			],
			$testComponent->export()
		);
	}

	public function test_set_description(): void
	{
		$testComponent = new TestComponentWithHasDescriptionTrait();

		$testComponent->setDescription("This is tha description");

		$this->assertEquals(
			[
				"nodeType" => "TestComponentWithHasDescriptionTrait",
				"description" => "This is tha description",
			],
			$testComponent->export()
		);
	}
}
