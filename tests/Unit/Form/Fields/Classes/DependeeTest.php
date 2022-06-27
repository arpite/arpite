<?php

use SudoBee\Cygnus\Component\Components\Panel;
use SudoBee\Cygnus\Form\Fields\Classes\Dependee;
use SudoBee\Cygnus\Form\Fields\TextField;
use SudoBee\Cygnus\Tests\Constants;

it("init state", function () {
	$dependee = Dependee::make("");

	expect($dependee->export())->toBe(Constants::dependee());
});

it("should have given value", function () {
	expect(Dependee::make("Tom")->export())->toHaveKey("value", "Tom");

	expect(Dependee::make(true)->export())->toHaveKey("value", true);
});

it("export should contain nodes", function () {
	expect(Dependee::make(true)->export())->toHaveKey("nodes", []);
});

it("should get fields default values", function () {
	$dependee = Dependee::make("Tom")->setNodes([
		TextField::make("First")->setDefaultValue("Dipsy"),
		Panel::make()->setNodes([TextField::make("Second")]),
	]);

	expect($dependee->getFieldsDefaultValues())->toHaveKeys([
		"first",
		"second",
	]);
	expect($dependee->getFieldsDefaultValues())->each->toBeString();
});

it("should get fields validation rules", function () {
	$dependee = Dependee::make("Tom")->setNodes([
		TextField::make("First")->addValidationRule("min:2"),
		Panel::make()->setNodes([TextField::make("Second")]),
	]);

	expect($dependee->getFieldsValidationRules((object) []))->toHaveKeys([
		"first",
		"second",
	]);
	expect($dependee->getFieldsValidationRules((object) []))
		->each->toBeArray()
		->toContain("required");
});

it("export should contain fields default values", function () {
	$dependee = Dependee::make("Tom")->setNodes([
		TextField::make("First")->setDefaultValue("Dipsy"),
		Panel::make()->setNodes([TextField::make("Second")]),
	]);

	expect($dependee->export()["fieldsDefaultValues"])->toBe(
		$dependee->getFieldsDefaultValues()
	);
});
