<?php

namespace SudoBee\Cygnus\Authentication\Pages;

use SudoBee\Cygnus\Authentication\Forms\ResetPasswordForm;
use SudoBee\Cygnus\Component\Components\Panel;
use SudoBee\Cygnus\Layout\Layout;
use SudoBee\Cygnus\Layout\Layouts\CentralLayout;
use SudoBee\Cygnus\Layout\Layouts\UnauthorizedLayout\UnauthorizedLayout;
use SudoBee\Cygnus\Page\Page;

class ResetPasswordPage extends Page
{
	public function title(): string
	{
		return "Change account password";
	}

	public function route(): string
	{
		return "/auth/password/reset/{token}/{email}";
	}

	public function routeName(): ?string
	{
		/**
		 * This is used by Laravel when it is generating
		 * letter for user.
		 */
		return "password.reset";
	}

	public function layout(): Layout
	{
		return CentralLayout::make()->setTitle($this->title());
	}

	public function nodes(): array
	{
		return [
			Panel::make()
				->setPadding(10)
				->setNodes([ResetPasswordForm::make()]),
		];
	}

	public function operations(): array
	{
		return [ResetPasswordForm::class];
	}
}
