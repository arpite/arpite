<?php

use SudoBee\Cygnus\Tests\Unit\Component\Traits\HasIcon\TestComponentWithHasIconTrait;

it("can set icon", function () {
	$testComponent = new TestComponentWithHasIconTrait();
	expect($testComponent->export())->toHaveKey("icon", null);

	$testComponent->setIcon("Bla_bla_icon_path");
	expect($testComponent->export())->toHaveKey("icon", "Bla_bla_icon_path");
});
