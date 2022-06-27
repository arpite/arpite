<?php

use SudoBee\Cygnus\Component\Components\PricingPlans\CurrentPricingPlan;
use SudoBee\Cygnus\Component\Components\PricingPlans\CurrentPricingPlans;
use SudoBee\Cygnus\Tests\Constants;

it("should have initial state", function () {
	$testComponent = CurrentPricingPlans::make();

	expect($testComponent->export())->toEqual(Constants::currentPricingPlans());
});

it("can set plans", function () {
	$testComponent = CurrentPricingPlans::make();
	$testComponent->setPlans([CurrentPricingPlan::make()]);

	expect($testComponent->export())->toEqual(
		Constants::currentPricingPlans([
			"plans" => [Constants::currentPricingPlan()],
		])
	);
});
