<?php

namespace SudoBee\Cygnus\Tests\Unit\Form\Form;

use SudoBee\Cygnus\Form\Form\FormButton;
use SudoBee\Cygnus\Tests\Constants;
use SudoBee\Cygnus\Tests\TestCase;

class FormButtonTest extends TestCase
{
	public function test_initial_state(): void
	{
		$formButton = FormButton::make();

		$this->assertEquals(Constants::formButton(), $formButton->export());
	}

	public function test_with_data(): void
	{
		$formButton = FormButton::make();

		$formButton->withData(["action" => "fire", "use" => false]);

		$this->assertEquals(
			array_merge(
				Constants::formButton([
					"withData" => ["action" => "fire", "use" => false],
				])
			),
			$formButton->export()
		);
	}

	public function test_force_action_response_type(): void
	{
		$formButton = FormButton::make();

		$formButton->forceActionResponseType("some_new_response_type");

		$this->assertEquals(
			Constants::formButton([
				"forceActionResponseType" => "some_new_response_type",
			]),
			$formButton->export()
		);
	}

	public function test_without_frontend_validation(): void
	{
		$formButton = FormButton::make();

		$this->assertEquals(
			Constants::formButton([
				"withoutFrontendValidation" => false,
			]),
			$formButton->export()
		);

		$formButton->withoutFrontendValidation();
		$this->assertEquals(
			Constants::formButton([
				"withoutFrontendValidation" => true,
			]),
			$formButton->export()
		);

		$formButton->withoutFrontendValidation(false);
		$this->assertEquals(
			Constants::formButton([
				"withoutFrontendValidation" => false,
			]),
			$formButton->export()
		);
	}
}
