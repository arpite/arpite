<?php

use Arpite\Layout\Layouts\LeftSideLayout;

it("should have initial export", function () {
	expect(LeftSideLayout::make()->export())->toHaveKey(
		"nodeType",
		"LeftSideLayout"
	);
});
