<?php

namespace Arpite\Authentication\Forms;

use Arpite\Authentication\Actions\CreateOrUpdateUserAction;
use Arpite\Authentication\Factories\UserFormFactory;
use Arpite\Core\Utilities\Notification;
use Arpite\Form\Form;
use Arpite\Form\ProcessableForm;
use Domain\Team\Models\User;

class UserEditForm extends ProcessableForm
{
	protected bool $resetAfterSubmit = true;

	public function route(): string
	{
		return "/user/edit";
	}

	protected function form(Form $form): Form
	{
		/** @var User $user */
		$user = auth()->user();

		return $form
			->setTitle("Edit profile")
			->setSubmitButtonText("Update")
			->setPreserveScroll()
			->setValues([
				"full_name" => $user->name,
				"email" => $user->email,
			])
			->setNodes(UserFormFactory::fields(user: $user));
	}

	public function handle(object $validated)
	{
		/** @var User $user */
		$user = auth()->user();

		app(CreateOrUpdateUserAction::class)->execute(
			validated: $validated,
			user: $user
		);

		Notification::success("User has been updated.");

		return redirect()->back();
	}
}
