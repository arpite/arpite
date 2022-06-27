<?php

namespace SudoBee\Cygnus\Tests\Unit\Form\Fields\Traits;

use SudoBee\Cygnus\Tests\TestCase;

class FieldWithHasMinAndMaxTraitTest extends TestCase
{
	public function test_initial_state(): void
	{
		$testField = new TestFieldWithHasMinAndMaxTrait("Comic Sans field");

		$this->assertEquals(
			["comic_sans_field" => ["required"]],
			$testField->getValidationRules((object) [])
		);
		$this->assertEquals(
			[
				"nodeType" => "TestFieldWithHasMinAndMaxTrait",
				"name" => "comic_sans_field",
				"label" => "Comic Sans field",
				"defaultValue" => "",
				"required" => true,
				"disabled" => false,
				"placeholder" => null,
				"explanation" => null,
				"min" => null,
				"max" => null,
				"dependees" => [],
			],
			$testField->export()
		);
	}

	public function test_set_min(): void
	{
		$testField = new TestFieldWithHasMinAndMaxTrait("Comic Sans field");

		$testField->setMin(20);
		$this->assertEquals(
			["comic_sans_field" => ["required", "min:20"]],
			$testField->getValidationRules((object) [])
		);
		$this->assertEquals(
			[
				"nodeType" => "TestFieldWithHasMinAndMaxTrait",
				"name" => "comic_sans_field",
				"label" => "Comic Sans field",
				"defaultValue" => "",
				"required" => true,
				"disabled" => false,
				"placeholder" => null,
				"explanation" => null,
				"min" => 20,
				"max" => null,
				"dependees" => [],
			],
			$testField->export()
		);

		$testField->setMin(null);
		$this->assertEquals(
			["comic_sans_field" => ["required"]],
			$testField->getValidationRules((object) [])
		);
		$this->assertEquals(
			[
				"nodeType" => "TestFieldWithHasMinAndMaxTrait",
				"name" => "comic_sans_field",
				"label" => "Comic Sans field",
				"defaultValue" => "",
				"required" => true,
				"disabled" => false,
				"placeholder" => null,
				"explanation" => null,
				"min" => null,
				"max" => null,
				"dependees" => [],
			],
			$testField->export()
		);
	}

	public function test_set_max(): void
	{
		$testField = new TestFieldWithHasMinAndMaxTrait("Comic Sans field");

		$testField->setMax(2550);
		$this->assertEquals(
			["comic_sans_field" => ["required", "max:2550"]],
			$testField->getValidationRules((object) [])
		);
		$this->assertEquals(
			[
				"nodeType" => "TestFieldWithHasMinAndMaxTrait",
				"name" => "comic_sans_field",
				"label" => "Comic Sans field",
				"defaultValue" => "",
				"required" => true,
				"disabled" => false,
				"placeholder" => null,
				"explanation" => null,
				"min" => null,
				"max" => 2550,
				"dependees" => [],
			],
			$testField->export()
		);

		$testField->setMax(null);
		$this->assertEquals(
			["comic_sans_field" => ["required"]],
			$testField->getValidationRules((object) [])
		);
		$this->assertEquals(
			[
				"nodeType" => "TestFieldWithHasMinAndMaxTrait",
				"name" => "comic_sans_field",
				"label" => "Comic Sans field",
				"defaultValue" => "",
				"required" => true,
				"disabled" => false,
				"placeholder" => null,
				"explanation" => null,
				"min" => null,
				"max" => null,
				"dependees" => [],
			],
			$testField->export()
		);
	}
}
