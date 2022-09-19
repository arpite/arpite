<?php

namespace Arpite\Tests\Unit\Form\Fields;

use Arpite\Component\Components\Text;
use Arpite\Component\Rules\DeepEqualRule;
use Arpite\Form\Fields\Enums\ValidationRule;
use Arpite\Form\Fields\Field;
use Exception;
use Illuminate\Validation\Rule;
use Arpite\Tests\Constants;
use Arpite\Tests\TestCase;

class FieldTest extends TestCase
{
	public function test_initial_state(): void
	{
		$testField = new TestField("First");

		$this->assertEquals(
			["first" => ["required"]],
			$testField->getValidationRules((object) [])
		);
		$this->assertEquals(Constants::field(), $testField->export());
	}

	public function test_should_set_custom_name(): void
	{
		$testField = new TestField("First", "kappa-custom");

		$this->assertEquals(
			Constants::field([
				"name" => "kappa-custom",
			]),
			$testField->export()
		);
	}

	public function test_set_explanation(): void
	{
		$testField = new TestField("First");

		$testField->setExplanation("You should buy e36.");

		$this->assertEquals(
			Constants::field([
				"explanation" => "You should buy e36.",
			]),
			$testField->export()
		);
	}

	public function test_set_placeholder(): void
	{
		$testField = new TestField("First");

		$testField->setPlaceholder("You should buy e36 now.");

		$this->assertEquals(
			Constants::field([
				"placeholder" => "You should buy e36 now.",
			]),
			$testField->export()
		);
	}

	public function test_add_and_remove_validation_rule(): void
	{
		$testField = new TestField("First");

		$this->assertEquals(
			["first" => ["required"]],
			$testField->getValidationRules((object) [])
		);

		$testField->addValidationRule("string");

		$this->assertEquals(
			["first" => ["required", "string"]],
			$testField->getValidationRules((object) [])
		);

		$testField->removeValidationRule("string");

		$this->assertEquals(
			["first" => ["required"]],
			$testField->getValidationRules((object) [])
		);
	}

	public function test_add_and_remove_validation_rule_with_starts_with(): void
	{
		$testField = new TestField("First");

		$this->assertEquals(
			["first" => ["required"]],
			$testField->getValidationRules((object) [])
		);

		$testField->addValidationRule("max:255");

		$this->assertEquals(
			["first" => ["required", "max:255"]],
			$testField->getValidationRules((object) [])
		);

		$testField->removeValidationRule("max");

		$this->assertEquals(
			["first" => ["required"]],
			$testField->getValidationRules((object) [])
		);
	}

	public function test_add_and_remove_required_validation_rule(): void
	{
		$testField = new TestField("First");

		$this->assertEquals(
			["first" => ["required"]],
			$testField->getValidationRules((object) [])
		);
		$this->assertEquals(Constants::field(), $testField->export());

		$testField->removeValidationRule("required");
		$this->assertEquals(
			["first" => []],
			$testField->getValidationRules((object) [])
		);
		$this->assertEquals(
			Constants::field(["required" => false]),
			$testField->export()
		);

		$testField->addValidationRule("required");
		$this->assertEquals(
			["first" => ["required"]],
			$testField->getValidationRules((object) [])
		);
		$this->assertEquals(Constants::field(), $testField->export());
	}

	public function test_validation_with_class(): void
	{
		$testField = new TestField("First");

		$this->assertEquals(
			["first" => ["required"]],
			$testField->getValidationRules((object) [])
		);

		$testField->addValidationRule(Rule::in(["value1", "value2"]));

		$this->assertEquals(
			["first" => ["required", Rule::in(["value1", "value2"])]],
			$testField->getValidationRules((object) [])
		);

		$testField->removeValidationRule(ValidationRule::RULE_IN);

		$this->assertEquals(
			["first" => ["required"]],
			$testField->getValidationRules((object) [])
		);
	}

	public function test_set_optional(): void
	{
		$testField = new TestField("First");

		$this->assertEquals(
			["first" => ["required"]],
			$testField->getValidationRules((object) [])
		);
		$this->assertEquals(Constants::field(), $testField->export());

		$testField->setOptional();

		$this->assertEquals(
			["first" => ["nullable"]],
			$testField->getValidationRules((object) [])
		);
		$this->assertEquals(
			Constants::field([
				"required" => false,
			]),
			$testField->export()
		);
	}

	public function test_set_default_value(): void
	{
		$testField = new TestField("First");

		$this->assertEquals(Constants::field(), $testField->export());

		$testField->setDefaultValue("This is the default value");
		$this->assertEquals(
			Constants::field([
				"defaultValue" => "This is the default value",
			]),
			$testField->export()
		);
	}

	public function test_get_name(): void
	{
		$testField = new TestField("First");

		$this->assertEquals("first", $testField->getName());
	}
}

it("getDefaultValue should return field default value", function () {
	$field = new TestField("First");

	expect($field->getDefaultValue((object) []))->toBe(["first" => null]);

	$field->setDefaultValue("Tom");
	expect($field->getDefaultValue((object) []))->toBe(["first" => "Tom"]);
});

it("should have proper rules when field is disabled", function () {
	$field = (new TestField("First"))
		->setDefaultValue(null)
		->addValidationRule("string")
		->addValidationRule("max:255");

	expect($field->getValidationRules((object) []))->toEqual([
		"first" => ["required", "string", "max:255"],
	]);

	$field->setDisabled();
	expect($field->getValidationRules((object) []))->toEqual([
		"first" => [new DeepEqualRule(null)],
	]);

	$field->setDefaultValue("Little Tommy");
	expect($field->getValidationRules((object) []))->toEqual([
		"first" => [new DeepEqualRule("Little Tommy")],
	]);
});

it("required property should work", function () {
	$field = new TestField("First");

	expect($field->export()["required"])->toBeTrue();

	$field->setOptional();
	expect($field->export()["required"])->toBeFalse();
});

it(
	"should throw exception when label is Text component and name is not provided",
	/**
	 * @throws Exception
	 */
	function () {
		new TestField(Text::make("Magic name", "with something"));
	}
)->throws(
	"When component Text is used for field label, the name must be provided."
);

test("addValidationRule should not add duplicate rule", function () {
	$field = new TestField("First");

	expect($field->getValidationRules((object) []))->first->toBe(["required"]);

	$field->addValidationRule("max:255")->addValidationRule("max:255");
	expect($field->getValidationRules((object) []))->first->toBe([
		"required",
		"max:255",
	]);
});

test(
	"addValidationRule should overwrite rule with same rule name",
	function () {
		$field = new TestField("First");

		expect($field->getValidationRules((object) []))->first->toBe([
			"required",
		]);

		$field->addValidationRule("max:255");
		expect($field->getValidationRules((object) []))->first->toBe([
			"required",
			"max:255",
		]);

		$field->addValidationRule("max:300");
		expect($field->getValidationRules((object) []))->first->toBe([
			"required",
			"max:300",
		]);
	}
);

test(
	"addValidationRule should overwrite class rule with same class name rule",
	function () {
		$field = new TestField("First");

		expect($field->getValidationRules((object) []))->first->toBe([
			"required",
		]);

		$ruleIn1 = Rule::in(["boo", "foo"]);
		$field->addValidationRule($ruleIn1);
		expect($field->getValidationRules((object) []))->first->toBe([
			"required",
			$ruleIn1,
		]);

		$ruleUnique1 = Rule::unique("users");
		$field->addValidationRule($ruleUnique1);
		expect($field->getValidationRules((object) []))->first->toBe([
			"required",
			$ruleIn1,
			$ruleUnique1,
		]);

		$ruleIn2 = Rule::in(["world"]);
		$field->addValidationRule($ruleIn2);
		expect($field->getValidationRules((object) []))->first->toBe([
			"required",
			$ruleUnique1,
			$ruleIn2,
		]);
	}
);

test(
	"addValidationRule should overwrite string rule with same class name rule",
	function () {
		$field = new TestField("First");

		expect($field->getValidationRules((object) []))->first->toBe([
			"required",
		]);

		$ruleIn1 = ValidationRule::RULE_IN;
		$field->addValidationRule($ruleIn1);
		expect($field->getValidationRules((object) []))->first->toBe([
			"required",
			$ruleIn1,
		]);

		$ruleUnique1 = Rule::unique("users");
		$field->addValidationRule($ruleUnique1);
		expect($field->getValidationRules((object) []))->first->toBe([
			"required",
			$ruleIn1,
			$ruleUnique1,
		]);

		$ruleIn2 = Rule::in(["world"]);
		$field->addValidationRule($ruleIn2);
		expect($field->getValidationRules((object) []))->first->toBe([
			"required",
			$ruleUnique1,
			$ruleIn2,
		]);
	}
)->only();

test(
	"removeValidationRule should remove rule that starts with given string",
	function () {
		$field = new TestField("First");

		$field->addValidationRule("max:255");
		expect($field->getValidationRules((object) []))->first->toBe([
			"required",
			"max:255",
		]);

		$field->removeValidationRule("max");
		expect($field->getValidationRules((object) []))->first->toBe([
			"required",
		]);
	}
);

it("can set optional", function () {
	$field = new TestField("First");

	expect($field->getValidationRules((object) []))->first->toBe(["required"]);

	$field->setOptional();
	expect($field->getValidationRules((object) []))->first->toBe(["nullable"]);

	$field->setOptional(false);
	expect($field->getValidationRules((object) []))->first->toBe(["required"]);
});

test(
	"form values passed to `getValidationRules` function should overwrite default field value",
	function () {
		$field = new TestField("First");
		$field->setDisabled();

		$field->setDefaultValue("Tom");
		expect($field->getValidationRules((object) []))->first->toMatchArray([
			new DeepEqualRule("Tom"),
		]);

		expect(
			$field->getValidationRules((object) ["first" => "Bobby"])
		)->first->toMatchArray([new DeepEqualRule("Bobby")]);
	}
);

test(
	"form values passed to `getValidationRules` function should be used",
	function () {
		$field = new TestField("First");
		$field->setDisabled();

		expect($field->getValidationRules((object) []))->first->toMatchArray([
			new DeepEqualRule(null),
		]);

		expect(
			$field->getValidationRules((object) ["first" => "Bobby"])
		)->first->toMatchArray([new DeepEqualRule("Bobby")]);
	}
);
