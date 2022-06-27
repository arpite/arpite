<?php

namespace SudoBee\Cygnus\Tests\Unit\Form\Fields;

use SudoBee\Cygnus\Form\Fields\ToggleField;
use Illuminate\Validation\Rule;
use SudoBee\Cygnus\Tests\Constants;
use SudoBee\Cygnus\Tests\TestCase;

class ToggleFieldTest extends TestCase
{
	public function test_initial_state(): void
	{
		$testToggleField = ToggleField::make("Active");

		$this->assertEquals(
			["active" => ["required", Rule::in([true, false])]],
			$testToggleField->getValidationRules((object) [])
		);
		$this->assertEquals(
			Constants::toggleField(),
			$testToggleField->export()
		);
	}
}
