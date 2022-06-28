<?php

use Arpite\Arpite\Component\Components\Card\Card;
use Arpite\Arpite\Component\Components\Card\Enums\CardDesignEnum;
use Arpite\Arpite\Tests\Constants;

it("should have initial state", function () {
	$testCard = Card::make();

	expect($testCard->export())->toBe(Constants::card());
});

it("can change designs", function () {
	$testCard = Card::make();

	expect($testCard->export())->toBe(
		Constants::card(["design" => CardDesignEnum::REGULAR])
	);

	$testCard->asVertical();
	expect($testCard->export())->toBe(
		Constants::card(["design" => CardDesignEnum::VERTICAL])
	);

	$testCard->asRegular();
	expect($testCard->export())->toBe(
		Constants::card(["design" => CardDesignEnum::REGULAR])
	);
});
