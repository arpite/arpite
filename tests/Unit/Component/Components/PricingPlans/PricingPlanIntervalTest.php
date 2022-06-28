<?php

use Arpite\Arpite\Component\Components\PricingPlans\PricingPlanInterval;
use Arpite\Arpite\Tests\Constants;

it("should have initial state", function () {
	$testComponent = PricingPlanInterval::make();

	expect($testComponent->export())->toEqual(Constants::pricingPlanInterval());
});

it("can change active", function () {
	$testComponent = PricingPlanInterval::make();
	expect($testComponent->export())->toEqual(
		Constants::pricingPlanInterval([
			"active" => false,
		])
	);

	$testComponent->active();
	expect($testComponent->export())->toEqual(
		Constants::pricingPlanInterval([
			"active" => true,
		])
	);

	$testComponent->active(false);
	expect($testComponent->export())->toEqual(
		Constants::pricingPlanInterval([
			"active" => false,
		])
	);
});

it("can set price", function () {
	$testComponent = PricingPlanInterval::make();
	expect($testComponent->export())->toEqual(
		Constants::pricingPlanInterval([
			"price" => 0,
		])
	);

	$testComponent->setPrice(2020);
	expect($testComponent->export())->toEqual(
		Constants::pricingPlanInterval([
			"price" => 2020,
		])
	);
});
