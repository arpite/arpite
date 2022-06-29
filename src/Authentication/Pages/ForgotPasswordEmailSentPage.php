<?php

namespace Arpite\Authentication\Pages;

use Arpite\Authentication\Partials\SubtitleWithLoginPageLink;
use Arpite\Component\Components\Panel;
use Arpite\Component\Components\Text;
use Arpite\Layout\Layout;
use Arpite\Layout\Layouts\CentralLayout;
use Arpite\Page\Page;

class ForgotPasswordEmailSentPage extends Page
{
	public function title(): string
	{
		return "Reset your password";
	}

	public function route(): string
	{
		return "/auth/password/sent";
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
				->setNodes([Text::make("passwords.sent")]),
		];
	}
}
