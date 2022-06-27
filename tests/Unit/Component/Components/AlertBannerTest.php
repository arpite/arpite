<?php

use SudoBee\Cygnus\Component\Components\AlertBanner;
use SudoBee\Cygnus\Component\Enums\Icon;

it("should have initial export", function () {
	expect(AlertBanner::make()->export())->toBe([
		"nodeType" => "AlertBanner",
		"icon" => Icon::INFORMATION,
		"description" => null,
		"buttons" => [],
	]);
});
