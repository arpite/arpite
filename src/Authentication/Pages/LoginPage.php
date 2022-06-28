<?php

namespace Arpite\Arpite\Authentication\Pages;

use Arpite\Arpite\Authentication\Forms\LoginForm;
use Arpite\Arpite\Component\Components\Link\Link;
use Arpite\Arpite\Component\Components\Panel;
use Arpite\Arpite\Component\Components\Text;
use Arpite\Arpite\Layout\Layout;
use Arpite\Arpite\Layout\Layouts\CentralLayout;
use Arpite\Arpite\Page\Page;

class LoginPage extends Page
{
	public function route(): string
	{
		return "/auth/login";
	}

	public function routeName(): string
	{
		return "login";
	}

	public function title(): string
	{
		return "Login to your account";
	}

	public function layout(): Layout
	{
		$layout = CentralLayout::make()->setTitle($this->title());

		if (AuthenticationPages::isRegistrationEnabled()) {
			$layout->setSubtitle(
				Text::make(
					"Or ",
					Link::make()
						->setTitle("create new account")
						->toPage(RegisterPage::class)
				)
			);
		}

		return $layout;
	}

	public function nodes(): array
	{
		return [
			Panel::make()
				->setPadding(10)
				->setNodes([LoginForm::make()]),
		];
	}

	public function operations(): array
	{
		return [LoginForm::class];
	}
}
