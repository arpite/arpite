<?php

namespace Arpite\Form;

use Arpite\Component\Component;
use Arpite\Component\Components\Table\Actions\GetTableSelectedValuesValidationRulesAction;
use Arpite\Component\Components\Wizard\Enums\WizardHeaderDesign;
use Arpite\Component\Components\Wizard\Partials\WizardStep;
use Arpite\Component\Components\Wizard\WizardContent;
use Arpite\Component\Components\Wizard\WizardHeader;
use Arpite\Core\Utilities\Notification;
use Arpite\Form\Actions\GetNestedFieldsValidationRulesAction;
use Arpite\Form\Enums\OperationResponseType;
use Arpite\Form\Form\FormButton;
use Arpite\Form\ProcessableWizard\ProcessableWizardForm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

// TODO: refactor code:
//          - instead of having "step" in validated data, have two variables: "submittedStep"
//            and "newStep", BUT to frontend send only "step" (which would technically be a "newStep")
//          - use DTO's for everything (especially for $validated, $additionalValidatedValues and other...)
//          - split this class code. maybe use actions or something else to make a class smaller
//          - rename "validated", "additionalDataValidation", "computedValues" and similar names to more
//            meaningful names
//          - cover this class fully in tests
abstract class ProcessableWizard extends Operation
{
	protected string $submitButtonLabel = "Submit";

	protected ?string $tableSelectedValuesModel = null;

	protected string $headerDesign = WizardHeaderDesign::STEPS;

	protected string $responseType = OperationResponseType::JSON;

	/**
	 * @return WizardStep[]
	 */
	abstract public function steps(object $validated): array;

	/**
	 * @return array<string, mixed>
	 */
	protected function additionalDataValidationRules(): array
	{
		return [];
	}

	/**
	 * @return array<string, mixed>
	 */
	protected function computedValuesValidationRules(): array
	{
		return [];
	}

	/**
	 * @param object $validatedComputedValues
	 * @param object $validated
	 * @return array<mixed>
	 */
	protected function computedValues(
		object $validatedComputedValues,
		object $validated
	): array {
		return (array) $validatedComputedValues;
	}

	protected function form(Form $form, object $validated): Form
	{
		return $form;
	}

	/**
	 * @param Request $request
	 * @return array<mixed>
	 * @throws ValidationException
	 */
	protected function validate(Request $request): array
	{
		$validatedAdditionalValues = $this->validateAdditionalValues($request);

		// TODO: restore previous values when coming back to step

		// TODO: in other places don't pass all validated data, only same as here
		$steps = $this->steps((object) $validatedAdditionalValues);

		try {
			$submitAction = Validator::validate($request->all(), [
				"submitAction" => [
					"required",
					Rule::in("next", "back", "reload"),
				],
			])["submitAction"];

			$step = Validator::validate($request->all(), [
				"step" => [
					"required",
					"integer",
					"min:" . ($submitAction === "back" ? 1 : 0),
					"max:" . (count($steps) - 1),
				],
			])["step"];

			$validated = array_merge($validatedAdditionalValues, [
				"step" => $step,
				"submitAction" => $submitAction,
			]);

			$newStepIndex = $this->getNewStepIndex((object) $validated);
			$validated["computedValues"] = $this->computedValues(
				(object) $this->validateComputedValues($request),
				(object) array_merge(
					$validated,
					Validator::validate(
						$request->all(),
						$this->additionalDataValidationRules()
					),
					["step" => $newStepIndex]
				)
			);
		} catch (ValidationException $exception) {
			Notification::danger("Please try again later.");

			throw $exception;
		}

		return array_merge(
			$this->validateStepsValues($request, $validated, $steps),
			$validated
		);
	}

	/**
	 * @param Request $request
	 * @return array<mixed>
	 * @throws ValidationException
	 */
	private function validateAdditionalValues(Request $request): array
	{
		$validateAdditionalValues = [];

		try {
			if ($this->tableSelectedValuesModel !== null) {
				$validateAdditionalValues = array_merge(
					$validateAdditionalValues,
					Validator::validate(
						$request->all(),
						app(
							GetTableSelectedValuesValidationRulesAction::class
						)->execute($this->tableSelectedValuesModel)
					)
				);
			}
		} catch (ValidationException $exception) {
			Notification::danger("Please try again later.");

			throw $exception;
		}

		return $validateAdditionalValues;
	}

	/**
	 * @param Request $request
	 * @return array<mixed>
	 * @throws ValidationException
	 */
	private function validateComputedValues(Request $request): array
	{
		try {
			return Validator::validate(
				$request->input("computedValues") ?? [],
				$this->computedValuesValidationRules()
			);
		} catch (ValidationException $exception) {
			Notification::danger("Please try again later.");

			throw $exception;
		}
	}

	/**
	 * @param Request $request
	 * @param array<string, mixed> $givenValidated
	 * @param WizardStep[] $steps
	 * @return array<string, mixed>
	 * @throws ValidationException
	 */
	private function validateStepsValues(
		Request $request,
		array $givenValidated,
		array $steps
	): array {
		$validated = [];

		$step = (int) $givenValidated["step"];
		$submitAction = $givenValidated["submitAction"];
		$stepsToValidate = array_slice(
			$steps,
			0,
			$submitAction === "next" ? $step + 1 : $step
		);

		$index = 0;
		array_map(function (WizardStep $wizardStep) use (
			$request,
			$givenValidated,
			$step,
			&$validated,
			&$index
		) {
			$rules = app(GetNestedFieldsValidationRulesAction::class)->execute(
				$this->getStepNodes(
					$wizardStep,
					(object) array_merge($givenValidated, $validated)
				),
				initialFormValues: (object) [],
				unvalidatedFormValues: (object) $request->all()
			);

			try {
				$validated = array_merge(
					$validated,
					Validator::validate($request->all(), $rules)
				);
			} catch (ValidationException $exception) {
				/**
				 * We want to show error notification for user because if
				 * previous step validation fails, user will not see any
				 * errors on current step fields, this way we need to
				 * inform user that something is wrong.
				 * Technically this case should never happen, but if it happens
				 * most likely it will mean that there is a bug in our code
				 * somewhere.
				 */
				if ($index < $step) {
					Notification::danger("Please try again later.");
				}

				throw $exception;
			}

			$index++;
		},
		$stepsToValidate);

		return $validated;
	}

	/**
	 * @param WizardStep $wizardStep
	 * @param object $validated
	 * @return Component[]
	 */
	private function getStepNodes(
		WizardStep $wizardStep,
		object $validated
	): array {
		$validatedDataToPass = (array) $validated;

		$validatedDataToPass["step"] = $this->getNewStepIndex($validated);
		unset($validatedDataToPass["submitAction"]);

		return $wizardStep->getStepNodes((object) $validatedDataToPass);
	}

	private function getNewStepIndex(object $validated): int
	{
		return match ($validated->submitAction) {
			"next" => $validated->step + 1,
			"back" => $validated->step - 1,
			default => $validated->step,
		};
	}

	/**
	 * @param object $validated
	 * @return array<mixed>|\Illuminate\Http\RedirectResponse
	 */
	protected function callHandle(object $validated)
	{
		$stepsCount = count($this->steps($validated));

		$isLastStep = $stepsCount - 1 <= $validated->step;
		if ($isLastStep && $validated->submitAction === "next") {
			$validatedDataToPass = (array) $validated;
			unset($validatedDataToPass["step"]);
			unset($validatedDataToPass["submitAction"]);

			return $this->handle((object) $validatedDataToPass);
		}

		return $this->getForm($validated)->export();
	}

	public function getForm(object $validated): Form
	{
		$newStep = $this->getNewStepIndex($validated);

		$steps = $this->steps($validated);

		$newStepNodes =
			count($steps) === 0
				? []
				: $this->getStepNodes($steps[$newStep], $validated);

		$willBeLastStep = count($steps) - 1 <= $newStep;

		$values = array_merge((array) $validated, ["step" => $newStep]);
		unset($values["submitAction"]);

		/**
		 * We want to keep current step data when we reload it
		 */
		if ($validated->submitAction === "reload") {
			$rules = app(GetNestedFieldsValidationRulesAction::class)->execute(
				$this->getStepNodes($steps[$validated->step], $validated),
				initialFormValues: (object) [],
				unvalidatedFormValues: $validated
			);

			foreach ($rules as $name => $rule) {
				if (request()->has($name)) {
					$values[$name] = request()->input($name);
				}
			}
		}

		return $this->form(
			Form::make($this)
				->setLeftButtons([
					$newStep > 0
						? FormButton::make()
							->setTitle("Back")
							->asSecondaryWithBorder()
							->withData([
								"submitAction" => "back",
							])
							->withoutFrontendValidation()
						: null,
				])
				->setValues($values)
				->setRightButtons([
					FormButton::make()
						->setTitle(
							$willBeLastStep ? $this->submitButtonLabel : "Next"
						)
						->withData([
							"submitAction" => "next",
						])
						->forceActionResponseType(
							$willBeLastStep
								? OperationResponseType::REGULAR
								: null
						),
				])
				->setStickyHeader([
					WizardHeader::make()
						->setActiveIndex($newStep)
						->setDesign($this->headerDesign)
						->setSteps($this->steps($validated)),
				])
				->setNodes([WizardContent::make()->setNodes($newStepNodes)]),
			(object) $values
		);
	}

	/**
	 * @param array<string, string> $parameters
	 * @return ProcessableWizardForm
	 */
	public static function make(array $parameters = []): ProcessableWizardForm
	{
		$className = get_called_class();

		/** @var ProcessableWizard $processableWizard */
		/** @phpstan-ignore-next-line */
		$processableWizard = new $className();

		$processableWizard->parameters = $parameters;

		return ProcessableWizardForm::make($processableWizard);
	}
}
