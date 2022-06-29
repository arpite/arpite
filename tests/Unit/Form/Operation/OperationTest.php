<?php

namespace Arpite\Tests\Unit\Form\Operation;

use Arpite\Form\AbstractOperationStore;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Arpite\Tests\TestCase;

class OperationTest extends TestCase
{
	/**
	 * @throws ValidationException
	 */
	public function test_should_not_abort_when_authorized(): void
	{
		$this->withUser();
		$operation = new TestOperation();

		$response = $operation->handleRequest(request());
		expect($response)->toBeInstanceOf(JsonResponse::class);
		expect($operation->handleRequest(request())->getData())->toHaveKey(
			"success",
			true
		);
	}

	/**
	 * @throws ValidationException
	 */
	public function test_should_abort_when_not_authorized(): void
	{
		$this->withUser();
		$operation = new class extends TestOperation {
			public function authorize(): bool
			{
				return false;
			}
		};

		$response = $operation->handleRequest(request());
		expect($response)->toBeInstanceOf(JsonResponse::class);
		expect($operation->handleRequest(request())->getData())
			->toHaveKey("success", false)
			->notification->toHaveKey(
				"description",
				"You do not have permission for that."
			);
	}

	public function test_should_register_operation_route(): void
	{
		$operation = new class extends TestOperation {
			public function route(): string
			{
				return "/test/give-apples";
			}
		};
		$this->assertRouteSlugNotExist("/test/give-apples");

		$operation::register();
		$this->assertRouteSlugExist("/test/give-apples");
	}
}

it("should initialize store", function () {
	$operationWithStore = new TestOperationWithStore();

	expect($operationWithStore->store)->toBeInstanceOf(
		AbstractOperationStore::class
	);
});

it("should throw exception when store is not updated", function () {
	$operationWithStore = new TestOperationWithStore();

	expect($operationWithStore->store->user)->toBeNull();
})->throws(
	'Typed property App\Arpite\OperationStore::$user must not be accessed before initialization'
);

it(
	"should update store",
	/**
	 * @throws ValidationException
	 */
	function () {
		$this->withUser();

		$operationWithStore = new TestOperationWithStore();

		$operationWithStore->handleRequest(request());

		expect($operationWithStore->store->user)->not->toBeNull();
	}
);

it(
	'should gracefully handle exception thrown inside "handle" method',
	function () {
		$operation = new class extends TestOperation {
			public function handle(object $validated)
			{
				throw new Exception("Fake exception");
			}
		};

		$response = $operation->handleRequest(request());
		expect($response)->toBeInstanceOf(JsonResponse::class);
		expect($operation->handleRequest(request())->getData())
			->toHaveKey("success", false)
			->notification->toHaveKey(
				"description",
				"Sorry for inconvenience, please try again later."
			);
	}
);
