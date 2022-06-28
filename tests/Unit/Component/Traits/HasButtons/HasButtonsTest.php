<?php

namespace Arpite\Arpite\Tests\Unit\Component\Traits\HasButtons;

use Arpite\Arpite\Component\Components\Button\Button;
use Arpite\Arpite\Tests\Constants;
use Arpite\Arpite\Tests\TestCase;

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
