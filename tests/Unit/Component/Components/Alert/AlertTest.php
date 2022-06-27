<?php

namespace SudoBee\Cygnus\Tests\Unit\Component\Components\Alert;

use SudoBee\Cygnus\Component\Components\Alert\Alert;
use SudoBee\Cygnus\Component\Components\Alert\Enums\AlertType;
use SudoBee\Cygnus\Tests\TestCase;

class AlertTest extends TestCase
{
	public function test_initial_state(): void
	{
		$testAlert = Alert::make();

		$this->assertEquals(
			[
				"nodeType" => "Alert",
				"title" => null,
				"description" => null,
				"confirmButtonText" => "Confirm",
				"cancelButtonText" => "Cancel",
				"type" => "DANGER",
			],
			$testAlert->export()
		);
	}

	public function test_set_confirm_button_text(): void
	{
		$testAlert = Alert::make()->setConfirmButtonText("Confirme buttone");

		$this->assertEquals(
			[
				"nodeType" => "Alert",
				"title" => null,
				"description" => null,
				"confirmButtonText" => "Confirme buttone",
				"cancelButtonText" => "Cancel",
				"type" => "DANGER",
			],
			$testAlert->export()
		);
	}

	public function test_set_cancel_button_text(): void
	{
		$testAlert = Alert::make()->setCancelButtonText("Cancele buttone");

		$this->assertEquals(
			[
				"nodeType" => "Alert",
				"title" => null,
				"description" => null,
				"confirmButtonText" => "Confirm",
				"cancelButtonText" => "Cancele buttone",
				"type" => "DANGER",
			],
			$testAlert->export()
		);
	}

	public function test_set_type(): void
	{
		$testAlert = Alert::make()->setType(AlertType::QUESTION);

		$this->assertEquals(
			[
				"nodeType" => "Alert",
				"title" => null,
				"description" => null,
				"confirmButtonText" => "Confirm",
				"cancelButtonText" => "Cancel",
				"type" => "QUESTION",
			],
			$testAlert->export()
		);
	}
}
