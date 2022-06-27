<?php

namespace SudoBee\Cygnus\Authentication\Pages;

use SudoBee\Cygnus\Authentication\Forms\UserEditForm;
use SudoBee\Cygnus\Page\Page;

class UserEditPage extends Page
{
	public function route(): string
	{
		return "/user/edit";
	}

	public function title(): string
	{
		return "Edit profile";
	}

	public function nodes(): array
	{
		// TODO: split user form into two panels:
		//       - general information
		//       - change password
		return [UserEditForm::make()];
	}

	public function operations(): array
	{
		return [UserEditForm::class];
	}
}
