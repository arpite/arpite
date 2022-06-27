<?php

namespace SudoBee\Cygnus\Form;

use SudoBee\Cygnus\Component\Components\Table\Actions\GetTableSelectedValuesValidationRulesAction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

abstract class TableActionOperation extends Operation
{
	abstract protected function selectedValuesModel(): string;

	/**
	 * @param Request $request
	 * @return array<mixed>
	 * @throws ValidationException
	 */
	protected function validate(Request $request): array
	{
		$rules = app(
			GetTableSelectedValuesValidationRulesAction::class
		)->execute($this->selectedValuesModel());

		return Validator::validate($request->all(), $rules);
	}
}
