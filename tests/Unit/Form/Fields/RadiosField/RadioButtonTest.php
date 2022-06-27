<?php

namespace SudoBee\Cygnus\Tests\Unit\Form\Fields\RadiosField;

use SudoBee\Cygnus\Form\Fields\RadiosField\RadioButton;
use SudoBee\Cygnus\Tests\Constants;
use SudoBee\Cygnus\Tests\TestCase;

class RadioButtonTest extends TestCase
{
	public function test_initial_state(): void
	{
		$testRadioButton = RadioButton::make("Apple");

		$this->assertEquals(
			Constants::radiosButton(),
			$testRadioButton->export()
		);
	}

	public function test_get_value(): void
	{
		$testRadioButton = RadioButton::make("Abrikosas");

		$this->assertEquals("Abrikosas", $testRadioButton->getValue());
	}
}
