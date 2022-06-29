<?php

use Arpite\Component\Components\Splitter;

it("should have initial state", function () {
	expect(Splitter::make()->export())->toBe([
		"nodeType" => "Splitter",
		"title" => null,
	]);
});
