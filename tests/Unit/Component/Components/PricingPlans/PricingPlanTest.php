<?php

use Arpite\Arpite\Component\Components\PricingPlans\PricingPlan;
use Arpite\Arpite\Component\Components\PricingPlans\PricingPlanInterval;
use Arpite\Arpite\Tests\Constants;

it("should have initial state", function () {
	$testComponent = PricingPlan::make()
		->setMonthlyInterval(PricingPlanInterval::make())
		->setYearlyInterval(PricingPlanInterval::make());

	expect($testComponent->export())->toEqual(Constants::pricingPlan());
});

it("can set features", function () {
	$testComponent = PricingPlan::make()
		->setMonthlyInterval(PricingPlanInterval::make())
		->setYearlyInterval(PricingPlanInterval::make());

	$testComponent->setFeatures(["First Tom feature.", "Business feature."]);

	expect($testComponent->export())->toEqual(
		Constants::pricingPlan([
			"features" => ["First Tom feature.", "Business feature."],
		])
	);
});

it("can set monthly and yearly interval", function () {
	$testComponent = PricingPlan::make();

	$testComponent->setMonthlyInterval(
		PricingPlanInterval::make()->setPrice(2)
	);
	$testComponent->setYearlyInterval(PricingPlanInterval::make()->setPrice(5));

	expect($testComponent->export())->toEqual(
		Constants::pricingPlan([
			"monthlyInterval" => Constants::pricingPlanInterval([
				"price" => 2,
			]),
			"yearlyInterval" => Constants::pricingPlanInterval([
				"price" => 5,
			]),
		])
	);
});
