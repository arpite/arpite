<?php

namespace Arpite\Arpite\Authentication\Forms;

use App\Providers\RouteServiceProvider;
use Illuminate\Validation\Rule;
use Arpite\Arpite\Authentication\Actions\CreateOrUpdateUserAction;
use Arpite\Arpite\Authentication\Factories\UserFormFactory;
use Arpite\Arpite\Form\Fields\TextField;
use Arpite\Arpite\Form\Form;
use Arpite\Arpite\Form\Form\FormButton;
use Arpite\Arpite\Form\ProcessableForm;
use Domain\Team\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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

	public function handle(object $validated)
	{
		$user = app(CreateOrUpdateUserAction::class)->execute(
			validated: $validated,
			user: null
		);

		Auth::login($user);

		event(new Registered($user));

		return redirect(RouteServiceProvider::getHomepage());
	}
}
