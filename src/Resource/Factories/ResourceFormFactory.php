<?php

namespace SudoBee\Cygnus\Resource\Factories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use SudoBee\Cygnus\Core\Utilities\Translate;
use SudoBee\Cygnus\Form\Fields\Field;
use SudoBee\Cygnus\Form\Form;

class ResourceFormFactory
{
	/**
	 * @param Model|null $entity
	 * @param Collection<int, Field<mixed>> $fields
	 * @param string $actionLink
	 * @param string $modelHeadline
	 * @return Form
	 */
	public static function make(
		?Model $entity,
		Collection $fields,
		string $actionLink,
		string $modelHeadline
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
			->setValues($values)
			->setTitle(
				Translate::text($entity === null ? "Create new" : "Edit") .
					" " .
					Str::of($modelHeadline)->lower()
			)
			->setSubmitButtonText($entity === null ? "Create" : "Update")
			->setNodes($fields->all());
	}
}
