<?php

use SudoBee\Cygnus\Component\Components\Card\Card;
use SudoBee\Cygnus\Component\Components\Card\Enums\CardDesignEnum;
use SudoBee\Cygnus\Tests\Constants;

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
