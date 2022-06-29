<?php

namespace Arpite\Authentication\Pages;

use Arpite\Authentication\Forms\ForgotPasswordForm;
use Arpite\Authentication\Partials\SubtitleWithLoginPageLink;
use Arpite\Component\Components\Panel;
use Arpite\Layout\Layout;
use Arpite\Layout\Layouts\CentralLayout;
use Arpite\Page\Page;

class ForgotPasswordPage extends Page
{
	public function title(): string
	{
		return "Reset your password";
	}

	public function route(): string
	{
		return "/auth/password/forgot";
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
				->setNodes([ForgotPasswordForm::make()]),
		];
	}

	public function operations(): array
	{
		return [ForgotPasswordForm::class];
	}
}
