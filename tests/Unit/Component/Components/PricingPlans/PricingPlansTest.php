<?php

use SudoBee\Cygnus\Component\Components\PricingPlans\PricingPlan;
use SudoBee\Cygnus\Component\Components\PricingPlans\PricingPlanInterval;
use SudoBee\Cygnus\Component\Components\PricingPlans\PricingPlans;
use SudoBee\Cygnus\Tests\Constants;

it("should have initial state", function () {
	$testComponent = PricingPlans::make();

	expect($testComponent->export())->toEqual(Constants::pricingPlans());
});

it("can set plans", function () {
	$testComponent = PricingPlans::make();
	$testComponent->setPlans([
		PricingPlan::make()
			->setMonthlyInterval(PricingPlanInterval::make())
			->setYearlyInterval(PricingPlanInterval::make()),
	]);

	expect($testComponent->export())->toEqual(
		Constants::pricingPlans([
			"plans" => [Constants::pricingPlan()],
		])
	);
});
