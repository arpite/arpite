<?php

namespace Arpite\Authentication\Factories;

use Domain\Team\Models\User;
use Illuminate\Validation\Rule;
use Arpite\Form\Fields\TextField;

class UserFormFactory
{
	/**
	 * @param User|null $user
	 * @return array<int, TextField>
	 */
	/** @phpstan-ignore-next-line */
	public static function fields(?User $user): array
	{
		return [
			TextField::make("Full name"),
			TextField::make("Email")
				->presetEmail()
				->addValidationRule(Rule::unique("users")->ignore($user?->id)),
			TextField::make(
				$user === null ? "Password" : "New password",
				"password"
			)
				->presetPassword()
				->setOptional($user !== null),
		];
	}
}
