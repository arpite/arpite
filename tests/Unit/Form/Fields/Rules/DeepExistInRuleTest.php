<?php

use Arpite\Component\Rules\DeepExistInRule;
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
				"test-array2" => [
					"twig" => [
						"boo" => 1,
					],
				],
			],
			[
				"test-null" => new DeepExistInRule([null]),
				"test-false" => new DeepExistInRule([false]),
				"test-true" => new DeepExistInRule([true]),
				"test-number" => new DeepExistInRule([123]),
				"test-string" => new DeepExistInRule(["Hi bla up"]),
				"test-array" => new DeepExistInRule([
					[
						"bla" => [
							"boo" => 1,
						],
						"ups" => "up",
					],
				]),
				"test-array2" => new DeepExistInRule([
					null,
					[],
					[
						"twig" => [
							"boo" => 1,
						],
					],
					false,
					true,
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
				"test-null" => null,
				"test-array" => [
					"bla" => 1,
				],
			],
			[
				"test-null" => new DeepExistInRule([
					"",
					false,
					true,
					"bla",
					[],
				]),
				"test-array" => new DeepExistInRule([
					[
						"bla" => "1",
					],
					[],
					["boop" => 1],
				]),
			]
		);
		expect(false)->toBeTrue();
	} catch (ValidationException $exception) {
		expect($exception->errors())->toEqual([
			"test-null" => $m,
			"test-array" => $m,
		]);
	}
});
