<?php

namespace SudoBee\Cygnus\Tests\Unit\Component\Components;

use SudoBee\Cygnus\Component\Components\Button\Button;
use SudoBee\Cygnus\Tests\Constants;
use SudoBee\Cygnus\Tests\TestCase;

class ButtonTest extends TestCase
{
	public function test_initial_state(): void
	{
		$testButton = Button::make();

		$this->assertEquals(Constants::button(), $testButton->export());
	}
}

it("can change button type", function () {
	$testButton = Button::make();

	expect($testButton->export())->toHaveKey("fullWidth", false);

	$testButton->setFullWidth();
	expect($testButton->export())->toHaveKey("fullWidth", true);

	$testButton->setFullWidth(false);
	expect($testButton->export())->toHaveKey("fullWidth", false);
});
