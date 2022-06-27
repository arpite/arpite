<?php

namespace SudoBee\Cygnus\Form\Actions;

use SudoBee\Cygnus\Component\Component;
use SudoBee\Cygnus\Form\Fields\Field;

class GetNestedFieldsValidationRulesAction
{
	/**
	 * @param Component[] $nodes
	 * @param object $formValues
	 * @return array<string, mixed>
	 */
	public function execute(array $nodes, object $formValues): array
	{
		$fields = app(GetNestedFieldsAction::class)->execute($nodes);

		return array_reduce(
			$fields,
			fn(array $previous, Field $field) => array_merge(
				$previous,
				$field->getValidationRules($formValues)
			),
			[]
		);
	}
}
