<?php

use Arpite\Component\Components\Text;
use Arpite\Layout\Layouts\CentralLayout;

it("should have initial export", function () {
	expect(CentralLayout::make()->export())
		->toHaveKey("nodeType", "CentralLayout")
		->toHaveKey("subtitle", null);
});

it("can set subtitle", function () {
	$centralLayout = CentralLayout::make();

	$centralLayout->setSubtitle("Register here");

	expect($centralLayout->export())->toHaveKey(
		"subtitle",
		Text::make("Register here")->export()
	);
});
