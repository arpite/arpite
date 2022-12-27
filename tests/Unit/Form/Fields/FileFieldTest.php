<?php

use Arpite\Form\Fields\Classes\FileEntity;
use Arpite\Form\Fields\FileField;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Arpite\Tests\Constants;

it("should have init properties", function () {
	$field = FileField::make("First");

	expect($field->export())->toEqual(Constants::fileField());
	expect(
		$this->getPrivateProperty($field, "fileValidationRules")->all()
	)->toEqual(["file", "max:3072", "mimes:jpg,jpeg,png,bmp"]);
});

it("can change accepted extensions", function () {
	$field = FileField::make("First");

	expect($field->export())->toHaveKey("acceptedExtensions", [
		"jpg",
		"jpeg",
		"png",
		"bmp",
	]);
	expect(
		$this->getPrivateProperty($field, "fileValidationRules")->all()
	)->toEqual(["file", "max:3072", "mimes:jpg,jpeg,png,bmp"]);

	$field->setAcceptedExtensions(["pdf", "yml"]);
	expect($field->export())->toHaveKey("acceptedExtensions", ["pdf", "yml"]);
	expect(
		$this->getPrivateProperty($field, "fileValidationRules")->all()
	)->toEqual(["file", "max:3072", "mimes:pdf,yml"]);

	$field->setAcceptedExtensions([]);
	expect($field->export())->toHaveKey("acceptedExtensions", []);
	expect(
		$this->getPrivateProperty($field, "fileValidationRules")->all()
	)->toEqual(["file", "max:3072", "mimes:"]);
});

it("can set extensions for images", function () {
	$field = FileField::make("First");

	$field->setAcceptedExtensions(["pdf"]);
	expect($field->export())->toHaveKey("acceptedExtensions", ["pdf"]);
	expect(
		$this->getPrivateProperty($field, "fileValidationRules")->all()
	)->toEqual(["file", "max:3072", "mimes:pdf"]);

	$field->acceptOnlyImages();
	expect($field->export())->toHaveKey("acceptedExtensions", [
		"jpg",
		"jpeg",
		"png",
		"bmp",
	]);
	expect(
		$this->getPrivateProperty($field, "fileValidationRules")->all()
	)->toEqual(["file", "max:3072", "mimes:jpg,jpeg,png,bmp"]);
});

it("can set max file size", function () {
	$field = FileField::make("First");

	expect(
		$this->getPrivateProperty($field, "fileValidationRules")->all()
	)->toEqual(["file", "max:3072", "mimes:jpg,jpeg,png,bmp"]);

	$field->setMaxSize(1234);
	expect(
		$this->getPrivateProperty($field, "fileValidationRules")->all()
	)->toEqual([
		0 => "file",
		2 => "mimes:jpg,jpeg,png,bmp",
		3 => "max:1234",
	]);
});

it("should validate existing file properly", function () {
	$field = FileField::make("First");
	$testFile = FileEntity::make(identifier: "some-file-id", title: "Bla file");

	try {
		Validator::validate(
			["first" => [$testFile->export()]],
			$field->getValidationRules((object) [],  (object) [])
		);
		expect(false)->toBeTrue();
	} catch (ValidationException $exception) {
		expect($exception->errors())->toEqual([
			"first.0" => ["The given value is invalid."],
		]);
	}

	$field->setDefaultValue([$testFile]);
	Validator::validate(
		["first" => [$testFile->export()]],
		$field->getValidationRules((object) [],  (object) [])
	);
	expect(true)->toBeTrue();
});

it("should validate new file properly", function () {
	$field = FileField::make("First");
	$fakeInvalidFile = UploadedFile::fake()->create(
		name: "Blopfile",
		kilobytes: 9999999,
		mimeType: "image/png"
	);
	$fakeValidFile = UploadedFile::fake()->create(
		name: "Blopfile",
		kilobytes: 10,
		mimeType: "image/png"
	);

	try {
		Validator::validate(
			["first" => [$fakeInvalidFile]],
			$field->getValidationRules((object) [],  (object) [])
		);
		expect(false)->toBeTrue();
	} catch (ValidationException $exception) {
		expect($exception->errors())->toEqual([
			"first.0" => ["The field must not be greater than 3072 kilobytes."],
		]);
	}

	Validator::validate(
		["first" => [$fakeValidFile]],
		$field->getValidationRules((object) [],  (object) [])
	);
	expect(true)->toBeTrue();
});
