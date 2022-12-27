<?php

namespace Arpite\Resource\Factories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Arpite\Core\Utilities\Translate;
use Arpite\Form\Fields\Field;
use Arpite\Form\Form;

class ResourceFormFactory
{
	/**
	 * @param Model|null $entity
	 * @param Collection<int, Field<mixed>> $fields
	 * @param string $actionLink
	 * @param string $modelHeadline
	 * @param callable $formValueParser
	 * @return Form
	 */
	public static function make(
		?Model $entity,
		Collection $fields,
		string $actionLink,
		string $modelHeadline,
		callable $formValueParser
	): Form {
		$values =
			$entity === null
				? []
				: $fields
					->mapWithKeys(
						fn(Field $field) => [
							$field->getName() => $entity->{$field->getName()},
						]
					)
					->all();

		return Form::make($actionLink)
			->setValues($formValueParser($values, $entity))
			->setTitle(
				Translate::text($entity === null ? "Create new" : "Edit") .
					" " .
					Str::of($modelHeadline)->lower()
			)
			->setSubmitButtonText($entity === null ? "Create" : "Update")
			->setNodes($fields->all());
	}
}
