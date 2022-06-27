<?php

namespace SudoBee\Cygnus\Authentication\Pages;

use SudoBee\Cygnus\Authentication\Forms\RegisterForm;
use SudoBee\Cygnus\Authentication\Partials\SubtitleWithLoginPageLink;
use SudoBee\Cygnus\Component\Components\Panel;
use SudoBee\Cygnus\Layout\Layout;
use SudoBee\Cygnus\Layout\Layouts\CentralLayout;
use SudoBee\Cygnus\Page\Page;

class RegisterPage extends Page
{
	public function route(): string
	{
		return "/auth/register";
	}

	public function title(): string
	{
		return "Create new account";
	}

	public function layout(): Layout
	{
		return CentralLayout::make()
			->setTitle($this->title())
			->setSubtitle(SubtitleWithLoginPageLink::make());
	}

	public function nodes(): array
	{
		return [
			Panel::make()
				->setPadding(10)
				->setNodes([RegisterForm::make()]),
		];
	}

	public function operations(): array
	{
		return [RegisterForm::class];
	}
}
