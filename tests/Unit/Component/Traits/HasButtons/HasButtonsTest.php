<?php

namespace SudoBee\Cygnus\Tests\Unit\Component\Traits\HasButtons;

use SudoBee\Cygnus\Component\Components\Button\Button;
use SudoBee\Cygnus\Tests\Constants;
use SudoBee\Cygnus\Tests\TestCase;

const COMPONENT_EXPORT = [
	"nodeType" => "TestComponentWithHasButtonsTrait",
	"buttons" => [],
];

class HasButtonsTest extends TestCase
{
	public function test_initial_state(): void
	{
		$testComponent = new TestComponentWithHasButtonsTrait();

		$this->assertEquals(COMPONENT_EXPORT, $testComponent->export());
	}

	public function test_set_buttons(): void
	{
		$testEmptyState = (new TestComponentWithHasButtonsTrait())->setButtons([
			Button::make(),
		]);

		$this->assertEquals(
			array_merge(COMPONENT_EXPORT, [
				"buttons" => [Constants::button()],
			]),
			$testEmptyState->export()
		);
	}
}
