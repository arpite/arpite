<?php

namespace Arpite\Arpite\Tests\Unit\Component\Traits\HasTextAlign;

use Arpite\Arpite\Component\Enums\Align;
use Arpite\Arpite\Component\ResponsiveValue;

it("should have initial export", function () {
	expect((new TestComponentWithHasTextAlignTrait())->export())->toBe([
		"textAlign" => null,
	]);
});

it("can set text align", function () {
	$node = new TestComponentWithHasTextAlignTrait();
	expect($node->export())->toHaveKey("textAlign", null);

	$node->setTextAlign(Align::CENTER, md: Align::RIGHT);
	expect($node->export())->toHaveKey(
		"textAlign",
		ResponsiveValue::make(Align::CENTER, md: Align::RIGHT)->export()
	);
});
