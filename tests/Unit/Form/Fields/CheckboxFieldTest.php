<?php

use Arpite\Form\Fields\CheckboxField;
use Illuminate\Validation\Rule;

it("should have initial state", function () {
	expect(CheckboxField::make("Apple")->export())
		->toHaveKey("nodeType", "CheckboxField")
		->toHaveKey("description", null);
});

it("should have initial validation rules", function () {
	$validationRules = CheckboxField::make("Apple")->getValidationRules(
		(object) []
	)["apple"];

	expect($validationRules)
		->toBeArray()
		->toContain("boolean");

	$hasRuleInRule = collect($validationRules)->some(
		fn($rule) => $rule == Rule::in(true, false)
	);
	expect($hasRuleInRule)->toBe(true);
});

it("should have default value", function () {
	$defaultValue = CheckboxField::make("Apple")->getDefaultValue((object) [])[
		"apple"
	];

	expect($defaultValue)->toBe(false);
});
