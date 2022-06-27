<?php

use SudoBee\Cygnus\Component\ResponsiveValue;

it("should export all given values", function () {
	expect(
		ResponsiveValue::make(1, sm: 2, md: 6, lg: 8, xl: 10)->export()
	)->toBe([
		"d" => 1,
		"sm" => 2,
		"md" => 6,
		"lg" => 8,
		"xl" => 10,
	]);

	expect(ResponsiveValue::make(sm: 2, lg: 8)->export())->toBe([
		"sm" => 2,
		"lg" => 8,
	]);
});

it("should not include null values", function () {
	expect(ResponsiveValue::make()->export())->toBe([]);

	expect(ResponsiveValue::make(sm: null, xl: null)->export())->toBe([]);

	expect(
		ResponsiveValue::make(
			null,
			sm: null,
			md: null,
			lg: null,
			xl: null
		)->export()
	)->toBe([]);
});
