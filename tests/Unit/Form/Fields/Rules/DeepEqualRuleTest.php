<?php

use Arpite\Arpite\Component\Rules\DeepEqualRule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

it(
	"validation should pass",
	/**
	 * @throws ValidationException
	 */ function () {
		Validator::validate(
			[
				"test-null" => null,
				"test-false" => false,
				"test-true" => true,
				"test-number" => 123,
				"test-string" => "Hi bla up",
				"test-array" => [
					"bla" => [
						"boo" => 1,
					],
					"ups" => "up",
				],
			],
			[
				"test-null" => new DeepEqualRule(null),
				"test-false" => new DeepEqualRule(false),
				"test-true" => new DeepEqualRule(true),
				"test-number" => new DeepEqualRule(123),
				"test-string" => new DeepEqualRule("Hi bla up"),
				"test-array" => new DeepEqualRule([
					"bla" => [
						"boo" => 1,
					],
					"ups" => "up",
				]),
			]
		);

		expect(true)->toBeTrue();
	}
);

it("validation should fail and have proper error messages", function () {
	$m = ["The given value is invalid."];

	try {
		Validator::validate(
			[
				"test-null-with-empty-string" => null,
				"test-null-with-false" => null,
				"test-array-strict" => [
					"bla" => 1,
				],
			],
			[
				"test-null-with-empty-string" => new DeepEqualRule(""),
				"test-null-with-false" => new DeepEqualRule(false),
				"test-array-strict" => new DeepEqualRule([
					"bla" => "1",
				]),
			]
		);
		expect(false)->toBeTrue();
	} catch (ValidationException $exception) {
		expect($exception->errors())->toEqual([
			"test-null-with-empty-string" => $m,
			"test-null-with-false" => $m,
			"test-array-strict" => $m,
		]);
	}
});
