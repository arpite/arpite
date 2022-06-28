<?php

namespace Arpite\Arpite\Tests\Unit\Form\Fields;

use Arpite\Arpite\Form\Fields\ToggleField;
use Illuminate\Validation\Rule;
use Arpite\Arpite\Tests\Constants;
use Arpite\Arpite\Tests\TestCase;

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
