<?php

use SudoBee\Cygnus\Form\Fields\Classes\Dependee;
use SudoBee\Cygnus\Form\Fields\TextField;
use SudoBee\Cygnus\Tests\Unit\Form\Fields\TestField;

uses()->group("field-with-dependees");

it("should not contain dependees", function () {
	$field = new TestField("First");

	expect($field->export())->toHaveKey("dependees", []);
});

it("should add dependee", function () {
	$field = new TestField("First");

	$field->addDependee(Dependee::make(""));
	expect($field->export()["dependees"])
		->toBeArray()
		->toHaveCount(1);

	$field->addDependee(Dependee::make(""));
	$field->addDependee(Dependee::make(""));
	expect($field->export()["dependees"])
		->toBeArray()
		->toHaveCount(3);
});

it("should add dependees", function () {
	$field = new TestField("First");

	$field->addDependees([Dependee::make("")]);
	expect($field->export()["dependees"])
		->toBeArray()
		->toHaveCount(1);

	$field->addDependees([Dependee::make(""), Dependee::make("")]);
	expect($field->export()["dependees"])
		->toBeArray()
		->toHaveCount(3);
});

it("should add dependee and add dependees", function () {
	$field = new TestField("First");

	$field->addDependee(Dependee::make(""));
	expect($field->export()["dependees"])
		->toBeArray()
		->toHaveCount(1);

	$field->addDependees([Dependee::make(""), Dependee::make("")]);
	expect($field->export()["dependees"])
		->toBeArray()
		->toHaveCount(3);
});

it(
	'getDefaultValue should return dependee\'s fields default values ONLY when those dependees are active',
	function () {
		$field = TextField::make("First");

		$field->addDependee(
			Dependee::make("Tom")->setNodes([TextField::make("Full name")])
		);
		expect($field->getDefaultValue())
			->toHaveKeys(["first"])
			->each->toBeString();

		$field->setDefaultValue("Tom");
		expect($field->getDefaultValue())
			->toHaveKeys(["first", "full_name"])
			->each->toBeString();

		$field->addDependees([
			Dependee::make("Tom")->setNodes([TextField::make("Age")]),
			Dependee::make("Dipsy")->setNodes([TextField::make("Is bord")]),
		]);
		expect($field->getDefaultValue())
			->toHaveKeys(["first", "full_name", "age"])
			->each->toBeString();
	}
);

it(
	'getValidationRules should return dependee\'s fields validation rules ONLY when those dependees are active',
	function () {
		$field = new TestField("First");

		$field->addDependees([
			Dependee::make("Tom")->setNodes([TextField::make("Full name")]),
			Dependee::make("Tom")->setNodes([TextField::make("Age")]),
			Dependee::make("Dipsy")->setNodes([TextField::make("Is bord")]),
		]);

		expect($field->getValidationRules((object) ["first" => "Ricky"]))
			->toHaveKeys(["first"])
			->each->toBeArray();

		expect($field->getValidationRules((object) ["first" => "Tom"]))
			->toHaveKeys(["first", "full_name", "age"])
			->each->toBeArray();
	}
);
