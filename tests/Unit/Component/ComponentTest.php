<?php

use Arpite\Arpite\Tests\Constants;
use Arpite\Arpite\Tests\Unit\Component\TestComponent;

it("should export initial state", function () {
	$testComponent = new TestComponent();

	expect($testComponent->export())->toBe(Constants::testComponent());
});

test("show method should work properly", function () {
	$testComponent = new TestComponent();

	expect($testComponent->show(true))->toBe([$testComponent]);

	expect($testComponent->show(false))->toBe([]);
});
