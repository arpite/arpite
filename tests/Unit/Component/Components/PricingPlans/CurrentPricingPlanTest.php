<?php

use Arpite\Arpite\Component\Components\PricingPlans\CurrentPricingPlan;
use Arpite\Arpite\Tests\Constants;

it("should have initial state", function () {
	$testComponent = CurrentPricingPlan::make();

	expect($testComponent->export())->toEqual(Constants::currentPricingPlan());
});
