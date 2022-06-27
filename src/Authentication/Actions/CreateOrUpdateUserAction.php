<?php

namespace SudoBee\Cygnus\Authentication\Actions;

use Domain\Team\Models\User;
use Illuminate\Support\Facades\Hash;

class CreateOrUpdateUserAction
{
	public function execute(object $validated, ?User $user): User
	{
		/** @var string|null $password */
		/** @phpstan-ignore-next-line */
		$password = $validated->password;

		/** @var array<string, mixed> $data */
		$data = [
			/** @phpstan-ignore-next-line */
			"name" => $validated->full_name,
			/** @phpstan-ignore-next-line */
			"email" => $validated->email,
			...$password === null ? [] : ["password" => Hash::make($password)],
		];

		if ($user === null) {
			return User::create($data);
		}

		$user->update($data);

		return $user;
	}
}
