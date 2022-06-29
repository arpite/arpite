<?php

namespace Arpite\Tests\Unit\Form\Fields\RadiosField;

use Arpite\Form\Fields\RadiosField\RadioButton;
use Arpite\Tests\Constants;
use Arpite\Tests\TestCase;

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
