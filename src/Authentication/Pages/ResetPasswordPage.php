<?php

namespace Arpite\Authentication\Pages;

use Arpite\Authentication\Forms\ResetPasswordForm;
use Arpite\Component\Components\Panel;
use Arpite\Layout\Layout;
use Arpite\Layout\Layouts\CentralLayout;
use Arpite\Layout\Layouts\UnauthorizedLayout\UnauthorizedLayout;
use Arpite\Page\Page;

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
