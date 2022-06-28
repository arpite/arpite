<?php

namespace Arpite\Arpite\Form\Actions;

use Arpite\Arpite\Component\Component;
use Arpite\Arpite\Form\Fields\Field;

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
