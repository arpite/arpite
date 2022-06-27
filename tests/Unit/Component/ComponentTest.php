<?php

use SudoBee\Cygnus\Tests\Constants;
use SudoBee\Cygnus\Tests\Unit\Component\TestComponent;

it("should export initial state", function () {
	$testComponent = new TestComponent();

	expect($testComponent->export())->toBe(Constants::testComponent());
});

test("show method should work properly", function () {
	$testComponent = new TestComponent();

	expect($testComponent->show(true))->toBe([$testComponent]);

	expect($testComponent->show(false))->toBe([]);
});
