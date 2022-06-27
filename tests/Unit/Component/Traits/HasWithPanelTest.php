<?php

namespace SudoBee\Cygnus\Tests\Unit\Component\Traits;

use SudoBee\Cygnus\Tests\TestCase;

class HasWithPanelTest extends TestCase
{
	public function test_initial_state(): void
	{
		$testComponent = new TestComponentWithHasWithPanelTrait();

		$this->assertEquals(
			true,
			$this->getPrivateProperty($testComponent, "withPanel")
		);
	}

	public function test_without_panel(): void
	{
		$testComponent = new TestComponentWithHasWithPanelTrait();
		$this->assertEquals(
			true,
			$this->getPrivateProperty($testComponent, "withPanel")
		);

		$testComponent->withoutPanel();
		$this->assertEquals(
			false,
			$this->getPrivateProperty($testComponent, "withPanel")
		);
	}

	public function test_with_panel(): void
	{
		$testComponent = new TestComponentWithHasWithPanelTrait();
		$this->assertEquals(
			true,
			$this->getPrivateProperty($testComponent, "withPanel")
		);

		$testComponent->withPanel(false);
		$this->assertEquals(
			false,
			$this->getPrivateProperty($testComponent, "withPanel")
		);

		$testComponent->withPanel();
		$this->assertEquals(
			true,
			$this->getPrivateProperty($testComponent, "withPanel")
		);

		$testComponent->withPanel(false);
		$this->assertEquals(
			false,
			$this->getPrivateProperty($testComponent, "withPanel")
		);

		$testComponent->withPanel(true);
		$this->assertEquals(
			true,
			$this->getPrivateProperty($testComponent, "withPanel")
		);
	}
}

it("should match initial export", function () {
	expect((new TestComponentWithHasWithPanelTrait())->export())->toBe([
		"nodeType" => "TestComponentWithHasWithPanelTrait",
		"withPanel" => true,
	]);
});
