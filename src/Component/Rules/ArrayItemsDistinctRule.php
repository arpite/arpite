<?php

namespace Arpite\Component\Rules;

use Exception;
use Illuminate\Contracts\Validation\Rule;

class ArrayItemsDistinctRule implements Rule
{
	/**
	 * Create a new rule instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		//
	}

	/**
	 * Determine if the validation rule passes.
	 *
	 * @param string $attribute
	 * @param mixed $value
	 * @return bool
	 * @throws Exception
	 */
	public function passes($attribute, $value): bool
	{
		if (is_array($value)) {
			return count($value) === count(array_unique($value));
		}

		return true;
	}

	/**
	 * Get the validation error message.
	 *
	 * @return string
	 */
	public function message(): string
	{
		/** @phpstan-ignore-next-line */
		return __("The given items must be distinct.");
	}
}
