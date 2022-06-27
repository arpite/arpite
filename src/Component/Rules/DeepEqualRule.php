<?php

namespace SudoBee\Cygnus\Component\Rules;

use Exception;
use Illuminate\Contracts\Validation\Rule;

class DeepEqualRule implements Rule
{
	/**
	 * Create a new rule instance.
	 *
	 * @param mixed $assertValue
	 * @return void
	 */
	public function __construct(private mixed $assertValue)
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
		return json_encode($this->assertValue) === json_encode($value);
	}

	/**
	 * Get the validation error message.
	 *
	 * @return string
	 */
	public function message(): string
	{
		/** @phpstan-ignore-next-line */
		return __("The given value is invalid.");
	}
}
