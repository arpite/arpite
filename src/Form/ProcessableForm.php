<?php

namespace Arpite\Arpite\Form;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

abstract class ProcessableForm extends Operation
{
	protected bool $resetAfterSubmit = false;

	protected function form(Form $form): Form
	{
		return $form;
	}

	/**
	 * @param Request $request
	 * @return array<string, mixed>
	 * @throws ValidationException
	 */
	protected function validate(Request $request): array
	{
		return Validator::validate(
			$request->all(),
			$this->getForm()->getValidationRules((object) $request->all())
		);
	}

	private function getForm(): Form
	{
		return $this->form(Form::make($this));
	}

	/**
	 * @param object $validated
	 * @return mixed
	 */
	protected function callHandle(object $validated): mixed
	{
		if ($this->resetAfterSubmit) {
			session()->flash(
				"resetFormIdentifier",
				request()->input("_formIdentifier")
			);
		}

		return $this->handle($validated);
	}

	/**
	 * @param array<string, string> $parameters
	 * @return Form
	 */
	public static function make(array $parameters = []): Form
	{
		$className = get_called_class();

		/** @var ProcessableForm $processableForm */
		/** @phpstan-ignore-next-line */
		$processableForm = new $className();

		$processableForm->parameters = $parameters;

		$processableForm->updateStore();

		return $processableForm->getForm();
	}
}
