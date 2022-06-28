<?php

namespace Arpite\Arpite\Tests\Unit\Form\Operation;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Arpite\Arpite\Tests\TestCase;

class OperationWithInertiaResponseTest extends TestCase
{
	private function getInertiaRequest()
	{
		$request = request();

		$request->headers->set("X-Inertia", true);

		return $request;
	}

	/**
	 * @throws ValidationException
	 */
	public function test_should_return_specified_response(): void
	{
		$this->withUser();
		$operation = new class extends TestOperation {
			public function handle(object $validated): RedirectResponse
			{
				return redirect()->to("/test/redirection");
			}
		};

		$response = $operation->handleRequest($this->getInertiaRequest());

		$this->assertInstanceOf(RedirectResponse::class, $response);
		$this->assertEquals(redirect()->to("/test/redirection"), $response);
	}

	public function test_should_fail_validation_with_proper_response(): void
	{
		$this->withUser();
		$operation = new class extends TestOperation {
			public function validate(Request $request): array
			{
				return Validator::validate($request->all(), [
					"non-existing-field" => "required",
				]);
			}
		};

		try {
			$operation->handleRequest($this->getInertiaRequest());
		} catch (ValidationException $exception) {
			$this->assertTrue($exception instanceof ValidationException);
			$this->assertEquals(
				[
					"non-existing-field" => [
						"The non-existing-field field is required.",
					],
				],
				$exception->errors()
			);
			return;
		}

		$this->fail("No validation exception was thrown!");
	}
}
