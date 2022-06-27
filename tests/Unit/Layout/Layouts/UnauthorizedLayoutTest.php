<?php

use SudoBee\Cygnus\Component\Components\Text;
use SudoBee\Cygnus\Layout\Layouts\UnauthorizedLayout\UnauthorizedLayout;

it("should have initial export", function () {
	expect(UnauthorizedLayout::make()->export())
		->toHaveKey("nodeType", "UnauthorizedLayout")
		->toHaveKey("subtitle", null)
		->toHaveKey("width", "lg");
});

it("can set subtitle", function () {
	$unauthorizedLayout = UnauthorizedLayout::make();

	$unauthorizedLayout->setSubtitle("Register here");

	expect($unauthorizedLayout->export())->toHaveKey(
		"subtitle",
		Text::make("Register here")->export()
	);
});

it("can set width", function () {
	$unauthorizedLayout = UnauthorizedLayout::make();
	expect($unauthorizedLayout->export())->toHaveKey("width", "lg");

	$unauthorizedLayout->asWidth2XL();
	expect($unauthorizedLayout->export())->toHaveKey("width", "2xl");

	$unauthorizedLayout->asWidthLG();
	expect($unauthorizedLayout->export())->toHaveKey("width", "lg");
});
