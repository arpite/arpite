<?php

use Arpite\Arpite\Component\Components\BalanceInformation;

it("should have initial export", function () {
	expect(BalanceInformation::make()->export())->toBe([
		"nodeType" => "BalanceInformation",
		"title" => null,
		"actions" => [],
	]);
});
