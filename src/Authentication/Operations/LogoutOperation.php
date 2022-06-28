<?php

namespace Arpite\Arpite\Authentication\Operations;

use Arpite\Arpite\Authentication\Actions\LogoutUserAction;
use Arpite\Arpite\Form\Operation;

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
