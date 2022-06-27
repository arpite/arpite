<?php

use SudoBee\Cygnus\Layout\Layouts\LeftSideLayout;

it("should have initial export", function () {
	expect(LeftSideLayout::make()->export())->toHaveKey(
		"nodeType",
		"LeftSideLayout"
	);
});
