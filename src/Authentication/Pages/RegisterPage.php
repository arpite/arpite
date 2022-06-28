<?php

namespace Arpite\Arpite\Authentication\Pages;

use Arpite\Arpite\Authentication\Forms\RegisterForm;
use Arpite\Arpite\Authentication\Partials\SubtitleWithLoginPageLink;
use Arpite\Arpite\Component\Components\Panel;
use Arpite\Arpite\Layout\Layout;
use Arpite\Arpite\Layout\Layouts\CentralLayout;
use Arpite\Arpite\Page\Page;

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
