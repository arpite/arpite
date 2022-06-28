<?php

namespace Arpite\Arpite\Form\Actions;

use Arpite\Arpite\Component\Component;
use Arpite\Arpite\Form\Fields\Field;

class GetNestedFieldsDefaultValuesAction
{
	/**
	 * @param Component[] $nodes
	 * @return array<string, mixed>
	 */
	public function execute(array $nodes, object $formValues): array
	{
		$fields = app(GetNestedFieldsAction::class)->execute($nodes);

		return array_reduce(
			$fields,
			function (array $previous, Component $field) use ($formValues) {
				if ($field instanceof Field) {
					$previous = array_merge(
						$previous,
						$field->getDefaultValue($formValues)
					);
				}

				return $previous;
			},
			[]
		);
	}
}
