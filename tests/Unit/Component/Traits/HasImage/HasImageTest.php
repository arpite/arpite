<?php

namespace SudoBee\Cygnus\Tests\Unit\Component\Traits\HasImage;

use SudoBee\Cygnus\Tests\TestCase;

const COMPONENT_EXPORT = [
	"nodeType" => "TestComponentWithHasImageTrait",
	"image" => null,
];

class HasImageTest extends TestCase
{
	public function test_initial_state(): void
	{
		$testComponent = new TestComponentWithHasImageTrait();

		$this->assertEquals(COMPONENT_EXPORT, $testComponent->export());
	}

	public function test_set_image(): void
	{
		$testEmptyState = (new TestComponentWithHasImageTrait())->setImage(
			"/images/svg/integration.svg"
		);

		$this->assertEquals(
			array_merge(COMPONENT_EXPORT, [
				"image" => "/images/svg/integration.svg",
			]),
			$testEmptyState->export()
		);
	}
}
