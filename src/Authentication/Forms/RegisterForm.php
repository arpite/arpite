<?php

namespace Arpite\Authentication\Forms;

use Arpite\Authentication\Actions\CreateOrUpdateUserAction;
use Arpite\Authentication\Actions\GetHomepageUrlAction;
use Arpite\Authentication\Factories\UserFormFactory;
use Arpite\Form\Form;
use Arpite\Form\Form\FormButton;
use Arpite\Form\ProcessableForm;
use Domain\Team\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;

class RegisterForm extends ProcessableForm
{
	public function route(): string
	{
		return "/auth/register";
	}

	protected function form(Form $form): Form
	{
		return $form
			->withoutPanel()
			->setNodes([
				...UserFormFactory::fields(user: null),
				FormButton::make()->setTitle("Register"),
			]);
	}

	/**
	 * @throws \Arpite\Authentication\Exceptions\HomepageNotFoundException
	 */
	public function handle(object $validated)
	{
		$user = app(CreateOrUpdateUserAction::class)->execute(
			validated: $validated,
			user: null
		);

		/** @phpstan-ignore-next-line */
		Auth::login($user);

		/** @phpstan-ignore-next-line */
		event(new Registered($user));

		/** @var GetHomepageUrlAction $getHomepageUrl */
		$getHomepageUrl = app(GetHomepageUrlAction::class);

		return redirect($getHomepageUrl->execute());
	}
}
