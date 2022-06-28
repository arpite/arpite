<?php

use Arpite\Arpite\Form\Fields\Classes\FileEntity;

it("should return correct array", function () {
	expect(
		FileEntity::make(identifier: 5, title: "Blop here")->export()
	)->toEqual([
		"identifier" => 5,
		"title" => "Blop here",
	]);
});
