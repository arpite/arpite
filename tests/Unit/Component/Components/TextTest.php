<?php

use SudoBee\Cygnus\Component\Components\Text;
use SudoBee\Cygnus\Tests\Unit\Component\TestComponent;

it("should match initial export", function () {
	expect(Text::make()->export())->toBe([
		"nodeType" => "Text",
		"nodesAndStrings" => [],
		"color" => null,
	]);
});

it("should have all given elements when exported", function () {
	$testText = Text::make(
		"This is ",
		new TestComponent(),
		" from future. You should ",
		new TestComponent(),
		"..."
	);

	expect($testText->export())->toHaveKey("nodesAndStrings", [
		"This is ",
		["nodeType" => "TestComponent"],
		" from future. You should ",
		["nodeType" => "TestComponent"],
		"...",
	]);
});

it('should filter out null\'s', function () {
	$testText = Text::make(
		"This is ",
		null,
		null,
		" from future. You should ",
		null,
		"..."
	);

	expect($testText->export())->toHaveKey("nodesAndStrings", [
		"This is ",
		" from future. You should ",
		"...",
	]);
});

it(
	"should return given instance if the only Text component is given",
	function () {
		$testText = Text::make(Text::make("This instance"));

		expect($testText->export())->toHaveKey("nodesAndStrings", [
			"This instance",
		]);
	}
);

it(
	"should return new instance of Text when has more than 1 elements given",
	function () {
		$childText = Text::make("This instance");

		expect(Text::make($childText, null)->export())->toHaveKey(
			"nodesAndStrings",
			[$childText->export()]
		);

		expect(Text::make($childText, "some text")->export())->toHaveKey(
			"nodesAndStrings",
			[$childText->export(), "some text"]
		);
	}
);

it("can set color", function () {
	$testText = Text::make("Boo");
	expect($testText->export())->toHaveKey("color", null);

	$testText->setColor("#eeeeee");
	expect($testText->export())->toHaveKey("color", "#eeeeee");
});
