<?php

use Arpite\Component\Components\PricingPlans\PricingPlan;
use Arpite\Component\Components\PricingPlans\PricingPlanInterval;
use Arpite\Component\Components\PricingPlans\PricingPlans;
use Arpite\Tests\Constants;

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
