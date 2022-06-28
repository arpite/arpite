<?php

namespace Arpite\Arpite\Resource\Traits;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Arpite\Arpite\Component\Component;
use Arpite\Arpite\Form\Actions\GetNestedFieldsAction;
use Arpite\Arpite\Form\Fields\Field;
use Arpite\Arpite\Form\Fields\TextField;
use Arpite\Arpite\Resource\Enums\ResourcePageType;

trait HasResourceFields
{
	/**
	 * @return array<int, Component>
	 */
	protected function fields(): array
	{
		$modelInstance = $this->getModelInstance();
		$primaryKey = $modelInstance->getKeyName();

		return [
			TextField::make(
				Str::of($primaryKey)
					->headline()
					->lower()
					->ucfirst(),
				$primaryKey
			)->setDisabled(),
		];
	}

	/**
	 * @param ResourcePageType $pageType
	 * @return Collection<int, Field<mixed>>
	 */
	private function getFieldsFor(ResourcePageType $pageType): Collection
	{
		$nodes = $this->fields();
		$fields = app(GetNestedFieldsAction::class)->execute($nodes);

		return collect($fields)->filter(
			fn(Field $field) => $field->shouldShowOn($pageType)
		);
	}
}
