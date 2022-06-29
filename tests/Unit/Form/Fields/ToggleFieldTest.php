<?php

namespace Arpite\Tests\Unit\Form\Fields;

use Arpite\Form\Fields\ToggleField;
use Illuminate\Validation\Rule;
use Arpite\Tests\Constants;
use Arpite\Tests\TestCase;

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
