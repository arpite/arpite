<?php

use Arpite\Component\Rules\ArrayItemsDistinctRule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

it(
	"validation should pass",
	/**
	 * @throws ValidationException
	 */ function () {
		Validator::validate(
			[
				"fruits1" => "not array value here",
				"fruits2" => ["apple", "pear", "banana"],
				"fruits3" => ["apple", "Apple"],
				"fruits4" => [true, false, 10, 20, "pear"],
			],
			[
				"fruits1" => new ArrayItemsDistinctRule(),
				"fruits2" => new ArrayItemsDistinctRule(),
				"fruits3" => new ArrayItemsDistinctRule(),
				"fruits4" => new ArrayItemsDistinctRule(),
			]
		);

		expect(true)->toBeTrue();
	}
);

it("validation should fail and have proper error messages", function () {
	$m = ["The given items must be distinct."];

	try {
		Validator::validate(
			[
				"fruits1" => ["apple", "apple"],
				"fruits2" => [10, 10],
				"fruits3" => [true, true],
				"fruits4" => [10, "10"],
				"fruits5" => [null, false],
				"fruits6" => [null, ""],
				"fruits7" => [false, ""],
			],
			[
				"fruits1" => new ArrayItemsDistinctRule(),
				"fruits2" => new ArrayItemsDistinctRule(),
				"fruits3" => new ArrayItemsDistinctRule(),
				"fruits4" => new ArrayItemsDistinctRule(),
				"fruits5" => new ArrayItemsDistinctRule(),
				"fruits6" => new ArrayItemsDistinctRule(),
				"fruits7" => new ArrayItemsDistinctRule(),
			]
		);
		expect(false)->toBeTrue();
	} catch (ValidationException $exception) {
		expect($exception->errors())->toEqual([
			"fruits1" => $m,
			"fruits2" => $m,
			"fruits3" => $m,
			"fruits4" => $m,
			"fruits5" => $m,
			"fruits6" => $m,
			"fruits7" => $m,
		]);
	}
});
