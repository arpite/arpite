<?php

use SudoBee\Cygnus\Layout\Layouts\TopSideLayout;

it("should have initial export", function () {
	expect(TopSideLayout::make()->export())->toHaveKey(
		"nodeType",
		"TopSideLayout"
	);
});
