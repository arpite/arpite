<?php

namespace SudoBee\Cygnus\Authentication\Actions;

class LogoutUserAction
{
	public function execute(): void
	{
		if (!auth()->check()) {
			return;
		}

		auth()->logout();

		request()
			->session()
			->invalidate();

		request()
			->session()
			->regenerateToken();
	}
}
