<?php

namespace SudoBee\Cygnus\Tests\Unit\Form\Fields;

use SudoBee\Cygnus\Form\Fields\TextField;
use Illuminate\Validation\Rules\Password;
use SudoBee\Cygnus\Tests\TestCase;

class TextFieldTest extends TestCase
{
	public function test_initial_state(): void
	{
		$field = TextField::make("First");

		$this->assertEquals(
			["first" => ["required", "string", "max:255"]],
			$field->getValidationRules((object) [])
		);
		$this->assertEquals(
			[
				"nodeType" => "TextField",
				"name" => "first",
				"label" => "First",
				"defaultValue" => "",
				"required" => true,
				"disabled" => false,
				"placeholder" => null,
				"explanation" => null,
				"type" => "text",
				"dependees" => [],
			],
			$field->export()
		);
	}

	public function test_set_type(): void
	{
		$field = TextField::make("First");

		$this->assertEquals(
			[
				"nodeType" => "TextField",
				"name" => "first",
				"label" => "First",
				"defaultValue" => "",
				"required" => true,
				"disabled" => false,
				"placeholder" => null,
				"explanation" => null,
				"type" => "text",
				"dependees" => [],
			],
			$field->export()
		);

		$field->setType("email");

		$this->assertEquals(
			[
				"nodeType" => "TextField",
				"name" => "first",
				"label" => "First",
				"defaultValue" => "",
				"required" => true,
				"disabled" => false,
				"placeholder" => null,
				"explanation" => null,
				"type" => "email",
				"dependees" => [],
			],
			$field->export()
		);
	}
}

it("should set email preset", function () {
	$field = TextField::make("First")->presetEmail();

	expect($field->export())->toHaveKey("type", "email");

	$fieldValidationRules = $field->getValidationRules((object) [])["first"];
	expect($fieldValidationRules)->toContain("email:rfc,dns");
});

it("should set password preset", function () {
	$field = TextField::make("First")->presetPassword();

	expect($field->export())->toHaveKey("type", "password");

	$fieldValidationRules = $field->getValidationRules((object) [])["first"];
	$hasPasswordDefaults = collect($fieldValidationRules)->some(
		fn($rule) => $rule instanceof Password
	);
	expect($hasPasswordDefaults)->toBe(true);
});
