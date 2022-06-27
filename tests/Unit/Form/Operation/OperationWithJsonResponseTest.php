<?php

namespace SudoBee\Cygnus\Tests\Unit\Form\Operation;

use SudoBee\Cygnus\Core\Utilities\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use SudoBee\Cygnus\Tests\Constants;
use SudoBee\Cygnus\Tests\TestCase;

class OperationWithJsonResponseTest extends TestCase
{
	/**
	 * @throws ValidationException
	 */
	public function test_should_have_specified_data(): void
	{
		$this->withUser();
		$operation = new class extends TestOperation {
			public function handle(object $validated): array
			{
				return ["companies" => []];
			}
		};

		$this->assertEquals(
			Constants::operationResponseJson([
				"data" => ["companies" => []],
			]),
			$operation->handleRequest(request())->original
		);
	}

	/**
	 * @throws ValidationException
	 */
	public function test_should_fail_validation_with_proper_response(): void
	{
		$this->withUser();
		$operation = new class extends TestOperation {
			public function validate(Request $request): array
			{
				return Validator::validate($request->all(), [
					"red-apple" => "required|string",
					"age" => "required|numeric|min:30",
				]);
			}
		};

		$request = request();
		$request->merge(["age" => 18]);
		$this->assertEquals(
			Constants::operationResponseJson([
				"success" => false,
				"data" => null,
				"errors" => [
					"red-apple" => "The red-apple field is required.",
					"age" => "The age must be at least 30.",
				],
			]),
			$operation->handleRequest($request)->original
		);
	}

	/**
	 * @throws ValidationException
	 */
	public function test_should_have_notification(): void
	{
		$this->withUser();

		$operation = new class extends TestOperation {
			public function handle(object $validated): array
			{
				Notification::success("New stuff was created!");

				return [];
			}
		};

		$this->assertEquals(
			Constants::operationResponseJson([
				"notification" => [
					"type" => "success",
					"title" => "Success!",
					"description" => "New stuff was created!",
				],
			]),
			$operation->handleRequest(request())->original
		);
	}
}
