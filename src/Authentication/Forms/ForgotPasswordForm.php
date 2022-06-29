<?php

namespace Arpite\Authentication\Forms;

use Arpite\Authentication\Jobs\SendResetPasswordMailJob;
use Arpite\Authentication\Pages\ForgotPasswordEmailSentPage;
use Arpite\Core\Utilities\Notification;
use Arpite\Form\Fields\TextField;
use Arpite\Form\Form;
use Arpite\Form\Form\FormButton;
use Arpite\Form\ProcessableForm;
use Arpite\Page\Utilities\Link;
use Domain\Team\Models\User;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

class ForgotPasswordForm extends ProcessableForm
{
	public function route(): string
	{
		return "/auth/password/forgot";
	}

	protected function form(Form $form): Form
	{
		return $form->withoutPanel()->setNodes([
			TextField::make("Email")
				->setType("email")
				->addValidationRule("email"),
			FormButton::make()->setTitle("Reset password"),
		]);
	}

	public function handle(object $validated)
	{
		$throttleKey = Str::lower(
			"reset-password|" . $validated->email . "|" . request()->ip()
		);

		$isRateLimitReached = RateLimiter::tooManyAttempts($throttleKey, 1);
		if ($isRateLimitReached) {
			Notification::danger(
				trans(
					"Too many password recovery attempts. Please try again in :seconds seconds.",
					[
						"seconds" => RateLimiter::availableIn($throttleKey),
					]
				)
			);

			return redirect()->back();
		}
		RateLimiter::hit($throttleKey);

		/** @var User|null $user */
		$user = User::whereEmail($validated->email)->first();

		if ($user !== null) {
			SendResetPasswordMailJob::dispatch($user->id);
		}

		/**
		 * We always redirect user to success page, even when the user
		 * does not exist, this way we do not disclose if user exists
		 * or not in database.
		 */
		return redirect()->to(Link::toPage(ForgotPasswordEmailSentPage::class));
	}
}
