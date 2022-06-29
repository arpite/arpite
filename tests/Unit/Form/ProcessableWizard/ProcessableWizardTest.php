<?php

namespace Arpite\Tests\Unit\Form\ProcessableWizard;

use Arpite\Component\Components\Wizard\Partials\WizardStep;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Arpite\Tests\Constants;
use Arpite\Tests\TestCase;

class ProcessableWizardTest extends TestCase
{
	private array $defaultStepForm;

	protected function setUp(): void
	{
		parent::setUp();

		$this->defaultStepForm = Constants::form([
			"action" => "/test/test-wizard",
			"values" => [
				"first" => "",
				"step" => 0,
				"computedValues" => [],
			],
			"actionResponseType" => "JSON",
		]);
	}

	private function getNewRequest($input): Request
	{
		$request = Request::createFrom(request());
		$request->merge($input);

		return $request;
	}

	private function getNewRequestWithInertia($input): Request
	{
		$request = $this->getNewRequest($input);

		$request->headers->set("X-Inertia", true);

		return $request;
	}

	public function test_should_have_response_type_json_by_default(): void
	{
		$wizard = new TestProcessableWizard();

		$this->assertEquals("JSON", $wizard->getResponseType());
	}

	public function test_should_return_json_response_type_for_not_last_steps(): void
	{
		$this->withUser();

		$wizard = new class extends TestProcessableWizard {
			public function steps(object $validated): array
			{
				return [
					WizardStepsHelper::stepFirst(),
					WizardStepsHelper::stepSecond(),
					WizardStepsHelper::stepThird(),
				];
			}
		};
		$response = $wizard->handleRequest(
			$this->getNewRequest([
				"step" => 0,
				"submitAction" => "next",
				"first" => "Tom",
			])
		);
		$this->assertEquals(
			"JSON",
			$response->original["data"]["actionResponseType"]
		);
	}

	public function test_should_return_danger_notification_if_previous_step_validation_fails(): void
	{
		$this->withUser();

		$wizard = new class extends TestProcessableWizard {
			public function steps(object $validated): array
			{
				return [
					WizardStepsHelper::stepFirst(),
					WizardStepsHelper::stepSecond(),
				];
			}
		};
		$response = $wizard->handleRequest(
			$this->getNewRequest([
				"step" => 1,
				"submitAction" => "next",
				"first" => null,
				"second1" => "Tom",
				"second2" => "Oak",
			])
		);
		$this->assertEquals(
			Constants::operationResponseJson([
				"success" => false,
				"data" => null,
				"errors" => [
					"first" => "The first field is required.",
				],
				"notification" => [
					"type" => "danger",
					"title" => "Something went wrong!",
					"description" => "Please try again later.",
				],
			]),
			$response->original
		);
	}

	public function test_should_return_validation_errors_for_current_step(): void
	{
		$this->withUser();

		$wizard = new class extends TestProcessableWizard {
			public function steps(object $validated): array
			{
				return [
					WizardStepsHelper::stepFirst(),
					WizardStepsHelper::stepSecond(),
					WizardStepsHelper::stepThird(),
				];
			}
		};
		$response = $wizard->handleRequest(
			$this->getNewRequest([
				"step" => 1,
				"submitAction" => "next",
				"first" => "Redson",
				"second1" => null,
				"second2" => "Rocky",
			])
		);
		$this->assertEquals(
			Constants::operationResponseJson([
				"success" => false,
				"data" => null,
				"errors" => [
					"second1" => "The second1 field is required.",
				],
			]),
			$response->original
		);
	}

	public function test_should_return_proper_next_button_text_for_not_last_steps(): void
	{
		$this->withUser();

		$wizard = new class extends TestProcessableWizard {
			public function steps(object $validated): array
			{
				return [
					WizardStepsHelper::stepFirst(),
					WizardStepsHelper::stepSecond(),
					WizardStepsHelper::stepThird(),
				];
			}
		};
		$response = $wizard->handleRequest(
			$this->getNewRequest([
				"step" => 0,
				"submitAction" => "next",
				"first" => "Redson",
			])
		);
		$this->assertEquals(
			"Next",
			$response->original["data"]["rightButtons"][0]["title"]
		);
	}

	public function test_should_return_proper_next_button_text_for_last_step(): void
	{
		$this->withUser();

		$wizard = new class extends TestProcessableWizard {
			public function steps(object $validated): array
			{
				return [
					WizardStepsHelper::stepFirst(),
					WizardStepsHelper::stepSecond(),
				];
			}
		};
		$response = $wizard->handleRequest(
			$this->getNewRequest([
				"step" => 0,
				"submitAction" => "next",
				"first" => "Redson",
			])
		);
		$this->assertEquals(
			"Submit",
			$response->original["data"]["rightButtons"][0]["title"]
		);
	}

	public function test_should_validate_previous_steps_values(): void
	{
		$this->withUser();

		$wizard = new class extends TestProcessableWizard {
			public function steps(object $validated): array
			{
				return [
					WizardStepsHelper::stepFirst(),
					WizardStepsHelper::stepSecond(),
					WizardStepsHelper::stepThird(),
				];
			}
		};
		$response = $wizard->handleRequest(
			$this->getNewRequest([
				"step" => 1,
				"submitAction" => "next",
			])
		);
		$this->assertEquals(
			["first" => "The first field is required."],
			$response->original["errors"]
		);
	}

	public function test_should_validate_current_step_values(): void
	{
		$this->withUser();

		$wizard = new class extends TestProcessableWizard {
			public function steps(object $validated): array
			{
				return [
					WizardStepsHelper::stepFirst(),
					WizardStepsHelper::stepSecond(),
					WizardStepsHelper::stepThird(),
				];
			}
		};
		$response = $wizard->handleRequest(
			$this->getNewRequest([
				"step" => 1,
				"submitAction" => "next",
				"first" => "Tom",
				"second2" => "Rick",
			])
		);
		$this->assertEquals(
			["second1" => "The second1 field is required."],
			$response->original["errors"]
		);
	}

	// TODO: write test: should_not_validate_current_step_when_going_back

	// TODO: uncomment this test and fix the issue in real code
	//	public function test_should_return_previous_step_when_going_back(): void
	//	{
	//		$this->withUser();
	//
	//		$wizard = new class extends TestProcessableWizard {
	//			public function steps(object $validated): array
	//			{
	//				return [
	//					WizardStepsHelper::stepFirst(),
	//					WizardStepsHelper::stepSecond(),
	//					WizardStepsHelper::stepThird(),
	//				];
	//			}
	//		};
	//		$response = $wizard->handleRequest(
	//			$this->getNewRequest([
	//				'step' => 2,
	//				'submitAction' => 'back',
	//				'first' => 'Tom',
	//				'second1' => 'Mom',
	//				'second2' => 'Rick',
	//				'unknown-field' => 'Bob',
	//			])
	//		);
	//		$this->assertEquals(true, $response->original['success']);
	//		$this->assertEquals(
	//			[
	//				'step' => 1,
	//				'first' => 'Tom',
	//				'second1' => 'Mom',
	//				'second2' => 'Rick',
	//			],
	//			$response->original['data']['values']
	//		);
	//	}

	public function test_should_provide_validated_previous_steps_data_to_current_step_get_nodes_function(): void
	{
		$this->withUser();

		$wizard = new class extends TestProcessableWizard {
			public function steps(object $validated): array
			{
				return [
					WizardStepsHelper::stepFirst(),
					WizardStepsHelper::stepSecond(),
					WizardStep::make()
						->setTitle("Third step title")
						->setGetStepNodes(function (object $validated) {
							return [];
						}),
				];
			}
		};

		$response = $wizard->handleRequest(
			$this->getNewRequest([
				"step" => 1,
				"submitAction" => "next",
				"first" => "Redson",
				"second1" => "Rocky",
				"second2" => "Datsan V12",
			])
		);

		expect($response->getData())
			->toHaveKey("success", true)
			->data->values->toMatchArray([
				"step" => 2,
				"first" => "Redson",
				"second1" => "Rocky",
				"second2" => "Datsan V12",
				"computedValues" => [],
			]);
	}

	public function test_should_provide_validated_previous_steps_data_to_previous_steps_get_nodes_functions(): void
	{
		$this->withUser();

		$wizard = new class extends TestProcessableWizard {
			public function steps(object $validated): array
			{
				return [
					WizardStepsHelper::stepFirst(),
					WizardStep::make()
						->setTitle("Second step title")
						->setGetStepNodes(function (object $validated) {
							return [];
						}),
					WizardStepsHelper::stepThird(),
				];
			}
		};

		$response = $wizard->handleRequest(
			$this->getNewRequest([
				"step" => 1,
				"submitAction" => "next",
				"first" => "Redson",
				"second1" => "Rocky",
				"second2" => "Datsan V12",
			])
		);

		expect($response->getData())
			->toHaveKey("success", true)
			->data->values->toMatchArray([
				"step" => 2,
				"first" => "Redson",
				"computedValues" => [],
			]);
	}

	// TODO: update this test to work
	public function test_should_provide_validated_all_steps_data_to_handle_method(): void
	{
		$this->markTestSkipped("Need to be updated to work with new code");

		//		$this->withUser();
		//
		//		$wizard = new class extends TestProcessableWizard {
		//			public function handle(object $validated)
		//			{
		//				throw new WizardStepsValidatedDataSpyException($validated);
		//			}
		//
		//			public function steps(object $validated): array
		//			{
		//				return [
		//					WizardStepsHelper::stepFirst(),
		//					WizardStepsHelper::stepSecond(),
		//					WizardStepsHelper::stepThird(),
		//				];
		//			}
		//		};
		//
		//		try {
		//			$wizard->handleRequest(
		//				$this->getNewRequest([
		//					"step" => 2,
		//					"submitAction" => "next",
		//					"first" => "Redson",
		//					"second1" => "Rocky",
		//					"second2" => "Datsan V12",
		//					"third" => "Apple",
		//				])
		//			);
		//		} catch (WizardStepsValidatedDataSpyException $exception) {
		//			$this->assertInstanceOf(
		//				WizardStepsValidatedDataSpyException::class,
		//				$exception
		//			);
		//			$this->assertEquals(
		//				[
		//					"first" => "Redson",
		//					"second1" => "Rocky",
		//					"second2" => "Datsan V12",
		//					"third" => "Apple",
		//					"computedValues" => [],
		//				],
		//				(array) $exception->getValidated()
		//			);
		//			return;
		//		}
		//
		//		$this->fail("Exception was not thrown!");
	}

	// TODO: write test, handleRequest should not return data with "submitAction" value

	public function test_should_return_previous_steps_and_current_step_values(): void
	{
		$this->withUser();

		$wizard = new class extends TestProcessableWizard {
			public function steps(object $validated): array
			{
				return [
					WizardStepsHelper::stepFirst(),
					WizardStepsHelper::stepSecond(),
					WizardStepsHelper::stepThird(),
				];
			}
		};
		$response = $wizard->handleRequest(
			$this->getNewRequest([
				"step" => 0,
				"submitAction" => "next",
				"first" => "Tom",
			])
		);
		$this->assertEquals(
			[
				"step" => 1,
				"first" => "Tom",
				"second1" => "",
				"second2" => "",
				"computedValues" => [],
			],
			$response->original["data"]["values"]
		);

		$response = $wizard->handleRequest(
			$this->getNewRequest([
				"step" => 1,
				"submitAction" => "next",
				"first" => "Tom",
				"second1" => "Rick",
				"second2" => "Oak",
			])
		);
		$this->assertEquals(
			[
				"step" => 2,
				"first" => "Tom",
				"second1" => "Rick",
				"second2" => "Oak",
				"third" => "",
				"computedValues" => [],
			],
			$response->original["data"]["values"]
		);
	}

	public function test_make_method_should_return_first_step(): void
	{
		$this->withUser();

		$wizard = new TestProcessableWizard();
		$this->assertEquals(
			array_merge($this->defaultStepForm, [
				"stickyHeader" => [
					Constants::wizardHeader([
						"steps" => [
							Constants::wizardStep([
								"title" => "First step title",
								"active" => true,
								"highlighted" => true,
							]),
							Constants::wizardStep([
								"title" => "Second step title",
								"index" => 1,
							]),
							Constants::wizardStep([
								"title" => "Third step title",
								"index" => 2,
							]),
						],
					]),
				],
				"nodes" => [
					Constants::wizardContent([
						"nodes" => [Constants::field()],
					]),
				],
				"rightButtons" => [
					Constants::formButton([
						"title" => "Next",
						"withData" => ["submitAction" => "next"],
					]),
				],
			]),
			$wizard
				::make()
				->getForm()
				->export()
		);
	}

	// TODO: write test validate submitAction

	public function test_validate_step_index(): void
	{
		$this->withUser();

		$wizard = new TestProcessableWizard();

		$stepsCount = count($wizard->steps((object) []));
		$this->assertEquals(3, $stepsCount);

		$this->assertEquals(
			Constants::operationResponseJson([
				"success" => false,
				"data" => null,
				"errors" => [
					"step" => "The step field is required.",
				],
				"notification" => [
					"type" => "danger",
					"title" => "Something went wrong!",
					"description" => "Please try again later.",
				],
			]),
			$wizard->handleRequest(
				$this->getNewRequest(["submitAction" => "next"])
			)->original
		);

		$this->assertEquals(
			Constants::operationResponseJson([
				"success" => false,
				"data" => null,
				"errors" => [
					"step" => "The step must be at least 0.",
				],
				"notification" => [
					"type" => "danger",
					"title" => "Something went wrong!",
					"description" => "Please try again later.",
				],
			]),
			$wizard->handleRequest(
				$this->getNewRequest(["step" => -1, "submitAction" => "next"])
			)->original
		);

		$this->assertEquals(
			Constants::operationResponseJson([
				"success" => false,
				"data" => null,
				"errors" => [
					"step" =>
						"The step must not be greater than " .
						($stepsCount - 1) .
						".",
				],
				"notification" => [
					"type" => "danger",
					"title" => "Something went wrong!",
					"description" => "Please try again later.",
				],
			]),
			$wizard->handleRequest(
				$this->getNewRequest(["step" => 999, "submitAction" => "next"])
			)->original
		);

		$this->assertEquals(
			Constants::operationResponseJson([
				"success" => false,
				"data" => null,
				"errors" => [
					"step" => "The step must be an integer.",
				],
				"notification" => [
					"type" => "danger",
					"title" => "Something went wrong!",
					"description" => "Please try again later.",
				],
			]),
			$wizard->handleRequest(
				$this->getNewRequest([
					"step" => "bla bla string",
					"submitAction" => "next",
				])
			)->original
		);
	}

	public function test_validate_submit_action(): void
	{
		$this->withUser();

		$wizard = new TestProcessableWizard();

		$this->assertEquals(
			Constants::operationResponseJson([
				"success" => false,
				"data" => null,
				"errors" => [
					"submitAction" => "The submit action field is required.",
				],
				"notification" => [
					"type" => "danger",
					"title" => "Something went wrong!",
					"description" => "Please try again later.",
				],
			]),
			$wizard->handleRequest($this->getNewRequest(["step" => 0]))
				->original
		);

		$this->assertEquals(
			Constants::operationResponseJson([
				"success" => false,
				"data" => null,
				"errors" => [
					"submitAction" => "The selected submit action is invalid.",
				],
				"notification" => [
					"type" => "danger",
					"title" => "Something went wrong!",
					"description" => "Please try again later.",
				],
			]),
			$wizard->handleRequest(
				$this->getNewRequest([
					"step" => 0,
					"submitAction" => "bla bla does not exist",
				])
			)->original
		);
	}

	public function test_should_have_correct_response_data_for_each_step(): void
	{
		$this->withUser();

		$wizard = new TestProcessableWizard();
		$this->assertEquals(
			array_merge($this->defaultStepForm, [
				"stickyHeader" => [
					Constants::wizardHeader([
						"steps" => [
							Constants::wizardStep([
								"title" => "First step title",
								"active" => true,
								"highlighted" => true,
							]),
							Constants::wizardStep([
								"title" => "Second step title",
								"index" => 1,
							]),
							Constants::wizardStep([
								"title" => "Third step title",
								"index" => 2,
							]),
						],
					]),
				],
				"nodes" => [
					Constants::wizardContent([
						"nodes" => [Constants::field()],
					]),
				],
				"rightButtons" => [
					Constants::formButton([
						"title" => "Next",
						"withData" => ["submitAction" => "next"],
					]),
				],
			]),
			$wizard
				::make()
				->getForm()
				->export()
		);

		$response = $wizard->handleRequest(
			$this->getNewRequest([
				"step" => 0,
				"submitAction" => "next",
				"first" => "Tom",
			])
		);
		$this->assertEquals(
			array_merge($this->defaultStepForm, [
				"values" => [
					"step" => 1,
					"first" => "Tom",
					"second1" => "",
					"second2" => "",
					"computedValues" => [],
				],
				"stickyHeader" => [
					Constants::wizardHeader([
						"steps" => [
							Constants::wizardStep([
								"title" => "First step title",
								"active" => false,
								"highlighted" => true,
							]),
							Constants::wizardStep([
								"title" => "Second step title",
								"active" => true,
								"highlighted" => true,
								"index" => 1,
							]),
							Constants::wizardStep([
								"title" => "Third step title",
								"index" => 2,
							]),
						],
						"activeIndex" => 1,
					]),
				],
				"nodes" => [
					Constants::wizardContent([
						"nodes" => [
							Constants::field([
								"name" => "second1",
								"label" => "Second1",
							]),
							Constants::field([
								"name" => "second2",
								"label" => "Second2",
							]),
						],
					]),
				],
				"leftButtons" => [
					Constants::formButton([
						"title" => "Back",
						"design" => "secondary-with-border",
						"withData" => ["submitAction" => "back"],
						"withoutFrontendValidation" => true,
					]),
				],
				"rightButtons" => [
					Constants::formButton([
						"title" => "Next",
						"withData" => ["submitAction" => "next"],
					]),
				],
			]),
			$response->original["data"]
		);

		$response = $wizard->handleRequest(
			$this->getNewRequest([
				"step" => 1,
				"submitAction" => "next",
				"first" => "Tom",
				"second1" => "Rick",
				"second2" => "Oak",
			])
		);
		$this->assertEquals(
			array_merge($this->defaultStepForm, [
				"values" => [
					"step" => 2,
					"first" => "Tom",
					"second1" => "Rick",
					"second2" => "Oak",
					"third" => "",
					"computedValues" => [],
				],
				"stickyHeader" => [
					Constants::wizardHeader([
						"steps" => [
							Constants::wizardStep([
								"title" => "First step title",
								"active" => false,
								"highlighted" => true,
							]),
							Constants::wizardStep([
								"title" => "Second step title",
								"active" => false,
								"highlighted" => true,
								"index" => 1,
							]),
							Constants::wizardStep([
								"title" => "Third step title",
								"active" => true,
								"highlighted" => true,
								"index" => 2,
							]),
						],
						"activeIndex" => 2,
					]),
				],
				"nodes" => [
					Constants::wizardContent([
						"nodes" => [
							Constants::field([
								"name" => "third",
								"label" => "Third",
							]),
						],
					]),
				],
				"leftButtons" => [
					Constants::formButton([
						"title" => "Back",
						"design" => "secondary-with-border",
						"withData" => ["submitAction" => "back"],
						"withoutFrontendValidation" => true,
					]),
				],
				"rightButtons" => [
					Constants::formButton([
						"title" => "Submit",
						"withData" => ["submitAction" => "next"],
						"forceActionResponseType" => "REGULAR",
					]),
				],
			]),
			$response->original["data"]
		);

		$response = $wizard->handleRequest(
			$this->getNewRequestWithInertia([
				"step" => 2,
				"submitAction" => "next",
				"first" => "Tom",
				"second1" => "Rick",
				"second2" => "Oak",
				"third" => "Doom",
			])
		);
		$this->assertInstanceOf(RedirectResponse::class, $response);
		$this->assertEquals(redirect("/test/somewhere"), $response);
	}
}
