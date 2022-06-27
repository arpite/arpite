<?php

namespace SudoBee\Cygnus\Tests\Unit\Form\Fields;

use SudoBee\Cygnus\Form\Fields\NumberField;
use SudoBee\Cygnus\Tests\TestCase;

class NumberFieldTest extends TestCase
{
	public function test_initial_state(): void
	{
		$field = NumberField::make("Ping Pong");

		$this->assertEquals(
			["ping_pong" => ["required", "numeric", "integer", "min:0"]],
			$field->getValidationRules((object) [])
		);
		$this->assertEquals(
			[
				"nodeType" => "NumberField",
				"name" => "ping_pong",
				"label" => "Ping Pong",
				"defaultValue" => "",
				"required" => true,
				"disabled" => false,
				"placeholder" => null,
				"explanation" => null,
				"suffix" => null,
				"decimalScale" => 2,
				"min" => 0,
				"max" => null,
				"dependees" => [],
			],
			$field->export()
		);
	}

	public function test_set_suffix(): void
	{
		$field = NumberField::make("Ping Pong")->setSuffix(" USD");

		$this->assertEquals(
			[
				"nodeType" => "NumberField",
				"name" => "ping_pong",
				"label" => "Ping Pong",
				"defaultValue" => "",
				"required" => true,
				"disabled" => false,
				"placeholder" => null,
				"explanation" => null,
				"suffix" => " USD",
				"decimalScale" => 2,
				"min" => 0,
				"max" => null,
				"dependees" => [],
			],
			$field->export()
		);
	}

	public function test_set_decimal_scale(): void
	{
		$field = NumberField::make("Ping Pong")->setDecimalScale(10);

		$this->assertEquals(
			[
				"nodeType" => "NumberField",
				"name" => "ping_pong",
				"label" => "Ping Pong",
				"defaultValue" => "",
				"required" => true,
				"disabled" => false,
				"placeholder" => null,
				"explanation" => null,
				"suffix" => null,
				"decimalScale" => 10,
				"min" => 0,
				"max" => null,
				"dependees" => [],
			],
			$field->export()
		);
	}

	public function test_preset_money(): void
	{
		$field = NumberField::make("Ping Pong")->presetMoney();

		$this->assertEquals(
			[
				"nodeType" => "NumberField",
				"name" => "ping_pong",
				"label" => "Ping Pong",
				"defaultValue" => "",
				"required" => true,
				"disabled" => false,
				"placeholder" => "0.00 EUR",
				"explanation" => null,
				"suffix" => " EUR",
				"decimalScale" => 2,
				"min" => 0,
				"max" => null,
				"dependees" => [],
			],
			$field->export()
		);
	}

	public function test_preset_weight(): void
	{
		$field = NumberField::make("Ping Pong")->presetWeight();

		$this->assertEquals(
			[
				"nodeType" => "NumberField",
				"name" => "ping_pong",
				"label" => "Ping Pong",
				"defaultValue" => "",
				"required" => true,
				"disabled" => false,
				"placeholder" => "0 g",
				"explanation" => null,
				"suffix" => " g",
				"decimalScale" => 0,
				"min" => 0,
				"max" => null,
				"dependees" => [],
			],
			$field->export()
		);
	}

	public function test_preset_dimension(): void
	{
		$field = NumberField::make("Ping Pong")->presetDimension();

		$this->assertEquals(
			[
				"nodeType" => "NumberField",
				"name" => "ping_pong",
				"label" => "Ping Pong",
				"defaultValue" => "",
				"required" => true,
				"disabled" => false,
				"placeholder" => "0.0 cm",
				"explanation" => null,
				"suffix" => " cm",
				"decimalScale" => 1,
				"min" => 0,
				"max" => null,
				"dependees" => [],
			],
			$field->export()
		);
	}
}
