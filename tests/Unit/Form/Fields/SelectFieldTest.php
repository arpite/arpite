<?php

namespace Arpite\Tests\Unit\Form\Fields;

use Arpite\Component\Rules\ArrayItemsDistinctRule;
use Arpite\Form\Fields\SelectField;
use Database\Seeders\DatabaseSeeder;
use Domain\Country\Models\Country;
use Exception;
use Illuminate\Validation\Rule;
use Arpite\Tests\TestCase;

class SelectFieldTest extends TestCase
{
	public function test_initial_state(): void
	{
		$field = SelectField::make("First");

		$this->assertEquals(
			["first" => ["required", Rule::in([])]],
			$field->getValidationRules((object) [], (object) [])
		);
		$this->assertEquals(
			[
				"nodeType" => "SelectField",
				"name" => "first",
				"label" => "First",
				"defaultValue" => null,
				"required" => true,
				"disabled" => false,
				"placeholder" => null,
				"explanation" => null,
				"options" => [],
				"dependees" => [],
				"searchable" => false,
				"multiple" => false,
			],
			$field->export()
		);
	}

	public function test_set_options(): void
	{
		$field = SelectField::make("First");

		$this->assertEquals(
			["first" => ["required", Rule::in([])]],
			$field->getValidationRules((object) [],  (object) [])
		);
		$field->setOptions([
			[
				"label" => "Omniva",
				"value" => "omniva",
				"image" => "/images/carriers/OmnivaCarrier.png",
			],
			[
				"label" => "DPD",
				"value" => "dpd",
				"image" => "/images/carriers/DPDCarrier.png",
			],
			[
				"label" => "LP Express",
				"value" => "lp-express",
				"image" => "/images/carriers/LPCarrier.png",
			],
		]);

		$this->assertEquals(
			[
				"first" => [
					"required",
					Rule::in(["omniva", "dpd", "lp-express"]),
				],
			],
			$field->getValidationRules((object) [],  (object) [])
		);
		$this->assertEquals(
			[
				"nodeType" => "SelectField",
				"name" => "first",
				"label" => "First",
				"defaultValue" => null,
				"required" => true,
				"disabled" => false,
				"placeholder" => null,
				"explanation" => null,
				"options" => [
					[
						"label" => "Omniva",
						"value" => "omniva",
						"image" => "/images/carriers/OmnivaCarrier.png",
					],
					[
						"label" => "DPD",
						"value" => "dpd",
						"image" => "/images/carriers/DPDCarrier.png",
					],
					[
						"label" => "LP Express",
						"value" => "lp-express",
						"image" => "/images/carriers/LPCarrier.png",
					],
				],
				"dependees" => [],
				"searchable" => false,
				"multiple" => false,
			],
			$field->export()
		);
	}
}

test("setMultiple method should work properly", function () {
	$field = SelectField::make("Country");
	expect($field->export())->multiple->toBe(false);

	$field->setMultiple();
	expect($field->export())->multiple->toBe(true);

	$field->setMultiple(false);
	expect($field->export())->multiple->toBe(false);
});

test("setSearchable method should work properly", function () {
	$field = SelectField::make("Country");
	expect($field->export())->searchable->toBe(false);

	$field->setSearchable();
	expect($field->export())->searchable->toBe(true);

	$field->setSearchable(false);
	expect($field->export())->searchable->toBe(false);
});

it("should have rule `in` with options values", function () {
	$field = SelectField::make("Country");
	expect($field->getValidationRules((object) [],  (object) []))->toEqual([
		"country" => ["required", Rule::in([])],
	]);

	$field->setOptions([
		["label" => "Apple", "value" => "apple"],
		["label" => "Banana", "value" => "banana"],
	]);
	expect($field->getValidationRules((object) [],  (object) []))->toEqual([
		"country" => ["required", Rule::in(["apple", "banana"])],
	]);
});

test(
	"should have `in` rule with options values when multiple selection enabled",
	function () {
		$field = SelectField::make("Country")->setMultiple();
		expect($field->getValidationRules((object) [],  (object) []))->toEqual([
			"country" => [
				"required",
				"array",
				new ArrayItemsDistinctRule(),
				Rule::in([]),
			],
		]);

		$field->setOptions([
			["label" => "Apple", "value" => "apple"],
			["label" => "Banana", "value" => "banana"],
		]);
		expect($field->getValidationRules((object) [],  (object) []))->toEqual([
			"country" => [
				"required",
				"array",
				new ArrayItemsDistinctRule(),
				Rule::in(["apple", "banana"]),
			],
		]);
	}
);

test("should have correct rules when switching multiple", function () {
	$field = SelectField::make("Country");
	expect($field->getValidationRules((object) [],  (object) []))->toEqual([
		"country" => ["required", Rule::in([])],
	]);

	$field->setMultiple();
	expect($field->getValidationRules((object) [],  (object) []))->toEqual([
		"country" => [
			"required",
			"array",
			new ArrayItemsDistinctRule(),
			Rule::in([]),
		],
	]);

	$field->setMultiple(false);
	expect($field->getValidationRules((object) [],  (object) []))->toEqual([
		"country" => ["required", Rule::in([])],
	]);
});

test(
	"should have `in` rule with values from options when changing options and multiple",
	function () {
		$field = SelectField::make("Country");
		expect($field->getValidationRules((object) [],  (object) []))->country->toEqual([
			"required",
			Rule::in([]),
		]);

		$field->setOptions([
			["label" => "Apple", "value" => "apple"],
			["label" => "Banana", "value" => "banana"],
		]);
		expect($field->getValidationRules((object) [],  (object) []))->country->toEqual([
			"required",
			Rule::in(["apple", "banana"]),
		]);

		$field->setMultiple();
		expect($field->getValidationRules((object) [],  (object) []))->country->toEqual([
			"required",
			"array",
			new ArrayItemsDistinctRule(),
			Rule::in(["apple", "banana"]),
		]);

		$field->setOptions([["label" => "Pear", "value" => "pear"]]);
		expect($field->getValidationRules((object) [],  (object) []))->country->toEqual([
			"required",
			"array",
			new ArrayItemsDistinctRule(),
			Rule::in(["pear"]),
		]);

		$field->setMultiple(false);
		expect($field->getValidationRules((object) [],  (object) []))->country->toEqual([
			"required",
			Rule::in(["pear"]),
		]);
	}
);

it("should have correct default value when switching multiple", function () {
	$field = SelectField::make("Country");
	expect($field->getDefaultValue((object) []))->toBe([
		"country" => null,
	]);

	$field->setMultiple();
	expect($field->getDefaultValue((object) []))->toEqual([
		"country" => [],
	]);

	$field->setMultiple(false);
	expect($field->getDefaultValue((object) []))->toEqual([
		"country" => null,
	]);
});

it(
	"should have correct dev provided default value when switching multiple selection",
	function () {
		$field = SelectField::make("Country");
		expect($field->getDefaultValue((object) []))->toBe([
			"country" => null,
		]);

		$field->setDefaultValue(["apple"]);
		expect($field->getDefaultValue((object) []))->toBe([
			"country" => ["apple"],
		]);
		$field->setMultiple();
		expect($field->getDefaultValue((object) []))->toBe([
			"country" => ["apple"],
		]);
	}
);

it(
	"should throw exception on export method when multiple selection enabled and default value is not array",
	function () {
		$field = SelectField::make("Country");

		$field->setMultiple()->setDefaultValue("apple");

		$field->export();
	}
)->throws(
	Exception::class,
	"SelectField default value must be array when multiple selection is enabled."
);

it(
	"should throw exception on export method when multiple selection not enabled and default value is array",
	function () {
		$field = SelectField::make("Country");

		$field->setDefaultValue(["pear", "apple"]);

		$field->export();
	}
)->throws(
	Exception::class,
	"SelectField default value must not be array when multiple selection is not enabled."
);
