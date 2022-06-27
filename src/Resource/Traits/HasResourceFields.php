<?php

namespace SudoBee\Cygnus\Resource\Traits;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use SudoBee\Cygnus\Component\Component;
use SudoBee\Cygnus\Form\Actions\GetNestedFieldsAction;
use SudoBee\Cygnus\Form\Fields\Field;
use SudoBee\Cygnus\Form\Fields\TextField;
use SudoBee\Cygnus\Resource\Enums\ResourcePageType;

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
