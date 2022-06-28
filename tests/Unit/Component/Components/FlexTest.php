<?php

use Arpite\Arpite\Component\Components\Flex\Enums\Display;
use Arpite\Arpite\Component\Components\Flex\Enums\Justify;
use Arpite\Arpite\Component\Components\Flex\Flex;
use Arpite\Arpite\Component\ResponsiveValue;

it("should have initial export", function () {
	expect(Flex::make()->export())->toBe([
		"nodeType" => "Flex",
		"nodes" => [],
		"display" => ResponsiveValue::make(Display::FLEX)->export(),
		"justifyContent" => null,
		"alignItems" => null,
	]);
});

it("can set justify content", function () {
	$testFlex = Flex::make();
	expect($testFlex->export())->toHaveKey("justifyContent", null);

	$testFlex->setJustify(sm: Justify::BETWEEN);
	expect($testFlex->export())->toHaveKey(
		"justifyContent",
		ResponsiveValue::make(sm: Justify::BETWEEN)->export()
	);
});

it("can set display", function () {
	$testFlex = Flex::make();
	expect($testFlex->export())->toHaveKey(
		"display",
		ResponsiveValue::make(Display::FLEX)->export()
	);

	$testFlex->setDisplay(lg: Display::FLEX);
	expect($testFlex->export())->toHaveKey(
		"display",
		ResponsiveValue::make(lg: Display::FLEX)->export()
	);
});

it("can set align items", function () {
	$testFlex = Flex::make();
	expect($testFlex->export())->toHaveKey("alignItems", null);

	$testFlex->setAlignStart();
	expect($testFlex->export())->toHaveKey("alignItems", "flex-start");

	$testFlex->setAlignEnd();
	expect($testFlex->export())->toHaveKey("alignItems", "flex-end");

	$testFlex->setAlignCenter();
	expect($testFlex->export())->toHaveKey("alignItems", "center");

	$testFlex->setAlignBaseline();
	expect($testFlex->export())->toHaveKey("alignItems", "baseline");

	$testFlex->setAlignStretch();
	expect($testFlex->export())->toHaveKey("alignItems", "stretch");
});
