<?php

namespace Arpite\Arpite\Tests\Unit\Form\Fields\RadiosField;

use Arpite\Arpite\Form\Fields\RadiosField\RadioButton;
use Arpite\Arpite\Tests\Constants;
use Arpite\Arpite\Tests\TestCase;

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
