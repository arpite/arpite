<?php

namespace SudoBee\Cygnus\Component\Rules;

use Exception;
use Illuminate\Contracts\Validation\Rule;

/**
 * @description
 *      Validated that submitted value exists
 *      in given array
 */
class DeepExistInRule implements Rule
{
	/**
	 * Create a new rule instance.
	 *
	 * @param array<mixed> $in
	 * @return void
	 */
	public function __construct(private array $in)
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
		return collect($this->in)->some(
			fn($acceptableValue) => json_encode($acceptableValue) ===
				json_encode($value)
		);
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
