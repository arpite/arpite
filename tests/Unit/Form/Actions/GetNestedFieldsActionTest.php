<?php

use SudoBee\Cygnus\Component\Components\Grid;
use SudoBee\Cygnus\Form\Actions\GetNestedFieldsAction;
use SudoBee\Cygnus\Form\Fields\TextField;

it("should get all nested fields default values", function () {
	$fields = [
		TextField::make("First"),
		TextField::make("Fourth"),
		TextField::make("Second"),
		TextField::make("Third"),
	];

	$defaultValues = app(GetNestedFieldsAction::class)->execute([
		Grid::make()->setNodes([
			$fields[0],
			Grid::make()->setNodes([$fields[1]]),
			$fields[2],
		]),
		$fields[3],
	]);

	expect($defaultValues)->toHaveCount(4);
	expect($defaultValues)->toBe($fields);
});
