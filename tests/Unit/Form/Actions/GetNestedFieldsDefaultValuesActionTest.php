<?php

use Arpite\Arpite\Component\Components\Grid;
use Arpite\Arpite\Form\Actions\GetNestedFieldsDefaultValuesAction;
use Arpite\Arpite\Form\Fields\TextField;

it("should get all nested fields default values", function () {
	$defaultValues = app(GetNestedFieldsDefaultValuesAction::class)->execute([
		Grid::make()->setNodes([
			TextField::make("First")->setDefaultValue("Tom"),
			Grid::make()->setNodes([TextField::make("Fourth")]),
			TextField::make("Second"),
		]),
		TextField::make("Third")->setDefaultValue("Jacky"),
	]);

	expect($defaultValues)->toBe([
		"first" => "Tom",
		"fourth" => "",
		"second" => "",
		"third" => "Jacky",
	]);
});
