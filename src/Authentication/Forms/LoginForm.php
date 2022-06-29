<?php

namespace Arpite\Authentication\Forms;

use App\Providers\RouteServiceProvider;
use Arpite\Authentication\Pages\AuthenticationPages;
use Arpite\Authentication\Pages\ForgotPasswordPage;
use Arpite\Component\Components\Flex\Enums\Justify;
use Arpite\Component\Components\Flex\Flex;
use Arpite\Component\Components\Link\Link;
use Arpite\Component\Enums\Align;
use Arpite\Core\Utilities\Notification;
use Arpite\Form\Fields\CheckboxField;
use Arpite\Form\Fields\TextField;
use Arpite\Form\Form;
use Arpite\Form\Form\FormButton;
use Arpite\Form\ProcessableForm;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

class LoginForm extends ProcessableForm
{
	public function route(): string
	{
		return "/auth/login";
	}

	protected function form(Form $form): Form
	{
		return $form->withoutPanel()->setNodes([
			TextField::make("Email")->setType("email"),
			TextField::make("Password")->setType("password"),
			Flex::make()
				->setJustify(Justify::BETWEEN)
				->setNodes([
					CheckboxField::make("Remember me"),
					...Link::make()
						->setTitle("Forgot your password?")
						->setTextAlign(Align::RIGHT)
						->toPage(ForgotPasswordPage::class)
						->show(AuthenticationPages::isPasswordResetEnabled()),
				]),
			FormButton::make()->setTitle("Login"),
		]);
	}

	public function handle(object $validated)
	{
		$throttleKey = Str::lower(
			"login|" . $validated->email . "|" . request()->ip()
		);

		$isRateLimitReached = RateLimiter::tooManyAttempts($throttleKey, 5);
		if ($isRateLimitReached) {
			Notification::danger(
				trans("auth.throttle", [
					"seconds" => RateLimiter::availableIn($throttleKey),
				])
			);

			return redirect()->back();
		}

		if (
			!Auth::attempt(
				[
					"email" => $validated->email,
					"password" => $validated->password,
				],
				$validated->remember_me
			)
		) {
			RateLimiter::hit($throttleKey);

			/** @phpstan-ignore-next-line */
			Notification::danger(__("auth.failed"));

			return redirect()->back();
		}

		RateLimiter::clear($throttleKey);

		session()->regenerate();

		return redirect()->intended(RouteServiceProvider::getHomepage());
	}
}
