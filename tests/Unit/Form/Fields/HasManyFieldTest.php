<?php

namespace SudoBee\Cygnus\Tests\Unit\Form\Fields;

use SudoBee\Cygnus\Component\Components\Grid;
use SudoBee\Cygnus\Form\Fields\Classes\Dependee;
use SudoBee\Cygnus\Form\Fields\HasManyField;
use SudoBee\Cygnus\Tests\Constants;
use SudoBee\Cygnus\Tests\TestCase;

class HasManyFieldTest extends TestCase
{
	public function test_initial_state(): void
	{
		$field = HasManyField::make("First");

		$this->assertEquals(
			["first" => ["nullable", "array"]],
			$field->getValidationRules((object) [])
		);
		$this->assertEquals(
			[
				"nodeType" => "HasManyField",
				"name" => "first",
				"label" => "First",
				"defaultValue" => [],
				"required" => false,
				"disabled" => false,
				"placeholder" => null,
				"explanation" => null,
				"addButtonText" => "Add new",
				"template" => [],
				"templateDefaultValue" => [],
				"dependees" => [],
			],
			$field->export()
		);
	}

	public function test_set_template(): void
	{
		$field = HasManyField::make("First")->setTemplate([
			Grid::make()->setNodes([
				(new TestField("Cookie name"))
					->setDefaultValue("Tommy Bobbinson")
					->addValidationRule("max:123"),
			]),
			(new TestField("Jar age"))
				->setDefaultValue("90")
				->addValidationRule("min:10"),
		]);

		$this->assertEquals(
			[
				"first" => ["nullable", "array"],
				"first.*.cookie_name" => ["required", "max:123"],
				"first.*.jar_age" => ["required", "min:10"],
			],
			$field->getValidationRules((object) [])
		);
		$this->assertEquals(
			[
				"nodeType" => "HasManyField",
				"name" => "first",
				"label" => "First",
				"defaultValue" => [],
				"required" => false,
				"disabled" => false,
				"placeholder" => null,
				"explanation" => null,
				"addButtonText" => "Add new",
				"template" => [
					[
						"nodeType" => "Grid",
						"columns" => ["d" => [1]],
						"nodes" => [
							Constants::field([
								"name" => "cookie_name",
								"label" => "Cookie name",
								"defaultValue" => "Tommy Bobbinson",
							]),
						],
						"gap" => 4,
					],
					Constants::field([
						"name" => "jar_age",
						"label" => "Jar age",
						"defaultValue" => "90",
					]),
				],
				"templateDefaultValue" => [
					"cookie_name" => "Tommy Bobbinson",
					"jar_age" => "90",
				],
				"dependees" => [],
			],
			$field->export()
		);
	}

	public function test_set_default_value(): void
	{
		$field = HasManyField::make("First");

		// Pass default value as COLLECTION
		$field->setDefaultValue(
			collect([
				(object) ["cookie_name" => "Been Pop", "jar_age" => "Rock"],
				["cookie_name" => "Jack", "jar_age" => "To"],
			])
		);
		$this->assertEquals(
			[
				"nodeType" => "HasManyField",
				"name" => "first",
				"label" => "First",
				"defaultValue" => [],
				"required" => false,
				"disabled" => false,
				"placeholder" => null,
				"explanation" => null,
				"addButtonText" => "Add new",
				"template" => [],
				"templateDefaultValue" => [],
				"dependees" => [],
			],
			$field->export()
		);

		$field->setTemplate([
			new TestField("Cookie name"),
			new TestField("Jar age"),
		]);
		$this->assertEquals(
			[
				"nodeType" => "HasManyField",
				"name" => "first",
				"label" => "First",
				"defaultValue" => [
					["cookie_name" => "Been Pop", "jar_age" => "Rock"],
					["cookie_name" => "Jack", "jar_age" => "To"],
				],
				"required" => false,
				"disabled" => false,
				"placeholder" => null,
				"explanation" => null,
				"addButtonText" => "Add new",
				"template" => [
					Constants::field([
						"name" => "cookie_name",
						"label" => "Cookie name",
					]),
					Constants::field([
						"name" => "jar_age",
						"label" => "Jar age",
					]),
				],
				"templateDefaultValue" => [
					"cookie_name" => "",
					"jar_age" => "",
				],
				"dependees" => [],
			],
			$field->export()
		);

		// Pass default value as ARRAY
		$field->setDefaultValue([
			(object) ["cookie_name" => "Op", "jar_age" => "Error"],
			(object) ["cookie_name" => "Place", "jar_age" => "Root"],
			["cookie_name" => "Car", "jar_age" => "Linux"],
		]);
		$this->assertEquals(
			[
				"nodeType" => "HasManyField",
				"name" => "first",
				"label" => "First",
				"defaultValue" => [
					["cookie_name" => "Op", "jar_age" => "Error"],
					["cookie_name" => "Place", "jar_age" => "Root"],
					["cookie_name" => "Car", "jar_age" => "Linux"],
				],
				"required" => false,
				"disabled" => false,
				"placeholder" => null,
				"explanation" => null,
				"addButtonText" => "Add new",
				"template" => [
					Constants::field([
						"name" => "cookie_name",
						"label" => "Cookie name",
					]),
					Constants::field([
						"name" => "jar_age",
						"label" => "Jar age",
					]),
				],
				"templateDefaultValue" => [
					"cookie_name" => "",
					"jar_age" => "",
				],
				"dependees" => [],
			],
			$field->export()
		);
	}
}

it("should throw exception when addDependee is called", function () {
	$field = HasManyField::make("First");

	$field->addDependee(Dependee::make(""));
})->throws("Dependees are not implemented for HasManyField yet.");

it("should throw exception when addDependees is called", function () {
	$field = HasManyField::make("First");

	$field->addDependees([Dependee::make("")]);
})->throws("Dependees are not implemented for HasManyField yet.");
