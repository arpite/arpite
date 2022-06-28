<?php

use Arpite\Arpite\Component\Components\AlertBanner;
use Arpite\Arpite\Component\Enums\Icon;

it("should have initial export", function () {
	expect(AlertBanner::make()->export())->toBe([
		"nodeType" => "AlertBanner",
		"icon" => Icon::INFORMATION,
		"description" => null,
		"buttons" => [],
	]);
});
