<?php

namespace Arpite\Form\Actions;

use Arpite\Component\Component;
use Arpite\Form\Fields\Field;

class GetNestedFieldsValidationRulesAction
{
	/**
	 * @param Component[] $nodes
	 * @param object $initialFormValues
	 * @param object $unvalidatedFormValues
	 * @return array<string, mixed>
	 */
	public function execute(
		array $nodes,
		object $initialFormValues,
		object $unvalidatedFormValues
	): array {
		$fields = app(GetNestedFieldsAction::class)->execute($nodes);

		return array_reduce(
			$fields,
			fn(array $previous, Field $field) => array_merge(
				$previous,
				$field->getValidationRules(
					initialFormValues: $initialFormValues,
					unvalidatedFormValues: $unvalidatedFormValues
				)
			),
			[]
		);
	}
}
