<?php

namespace SudoBee\Cygnus\Authentication\Operations;

use SudoBee\Cygnus\Authentication\Actions\LogoutUserAction;
use SudoBee\Cygnus\Form\Operation;

class LogoutOperation extends Operation
{
	public function route(): string
	{
		return "/auth/logout";
	}

	public function handle(object $validated)
	{
		app(LogoutUserAction::class)->execute();

		return redirect()->to("/");
	}
}
