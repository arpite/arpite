<?php

use Arpite\Component\Components\Grid;
use Arpite\Form\Actions\GetNestedFieldsValidationRulesAction;
use Arpite\Form\Fields\TextField;

it("should get all nested fields validation rules", function () {
	$defaultValues = app(GetNestedFieldsValidationRulesAction::class)->execute(
		[
			Grid::make()->setNodes([
				TextField::make("First")->addValidationRule("min:10"),
				Grid::make()->setNodes([TextField::make("Fourth")]),
				TextField::make("Second"),
			]),
			TextField::make("Third"),
		],
		(object) []
	);

	expect($defaultValues)->toBe([
		"first" => ["required", "string", "max:255", "min:10"],
		"fourth" => ["required", "string", "max:255"],
		"second" => ["required", "string", "max:255"],
		"third" => ["required", "string", "max:255"],
	]);
});
