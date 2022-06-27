<?php

namespace SudoBee\Cygnus\Tests\Unit\Form\Fields\RadiosField;

use SudoBee\Cygnus\Form\Fields\RadiosField\RadioButton;
use SudoBee\Cygnus\Form\Fields\RadiosField\RadiosField;
use Illuminate\Validation\Rule;
use SudoBee\Cygnus\Tests\Constants;
use SudoBee\Cygnus\Tests\TestCase;

class RadiosFieldTest extends TestCase
{
	public function test_initial_state(): void
	{
		$testRadiosField = RadiosField::make("Favorite fruit");

		$this->assertEquals(
			Constants::radiosField(),
			$testRadiosField->export()
		);
	}

	public function test_set_nodes(): void
	{
		$testRadiosField = RadiosField::make("Favorite fruit");

		$testRadiosField->setNodes([
			RadioButton::make("Root"),
			RadioButton::make("Carrot :)"),
		]);

		$this->assertEquals(
			Constants::radiosField([
				"radios" => [
					Constants::radiosButton([
						"value" => "Root",
					]),
					Constants::radiosButton([
						"value" => "Carrot :)",
					]),
				],
			]),
			$testRadiosField->export()
		);
	}

	public function test_should_have_rule_in_validation_rule(): void
	{
		$testRadiosField = RadiosField::make("Favorite fruit");
		$this->assertEquals(
			["favorite_fruit" => ["required"]],
			$testRadiosField->getValidationRules((object) [])
		);

		$testRadiosField->setNodes([
			RadioButton::make("Orange"),
			RadioButton::make("Pear"),
			RadioButton::make("Pineapple"),
			RadioButton::make("Carrot"),
		]);
		$this->assertEquals(
			[
				"favorite_fruit" => [
					"required",
					Rule::in(["Orange", "Pear", "Pineapple", "Carrot"]),
				],
			],
			$testRadiosField->getValidationRules((object) [])
		);
	}
}
