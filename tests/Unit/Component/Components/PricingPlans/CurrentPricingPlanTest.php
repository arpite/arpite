<?php

use SudoBee\Cygnus\Component\Components\PricingPlans\CurrentPricingPlan;
use SudoBee\Cygnus\Tests\Constants;

it("should have initial state", function () {
	$testComponent = CurrentPricingPlan::make();

	expect($testComponent->export())->toEqual(Constants::currentPricingPlan());
});
