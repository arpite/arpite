<?php

namespace SudoBee\Cygnus\Authentication\Forms;

use App\Providers\RouteServiceProvider;
use Illuminate\Validation\Rule;
use SudoBee\Cygnus\Authentication\Actions\CreateOrUpdateUserAction;
use SudoBee\Cygnus\Authentication\Factories\UserFormFactory;
use SudoBee\Cygnus\Form\Fields\TextField;
use SudoBee\Cygnus\Form\Form;
use SudoBee\Cygnus\Form\Form\FormButton;
use SudoBee\Cygnus\Form\ProcessableForm;
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
