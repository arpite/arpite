<?php

use Arpite\Arpite\Component\Components\PricingPlans\CurrentPricingPlan;
use Arpite\Arpite\Component\Components\PricingPlans\CurrentPricingPlans;
use Arpite\Arpite\Tests\Constants;

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
