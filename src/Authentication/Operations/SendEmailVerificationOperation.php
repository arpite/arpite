<?php

namespace SudoBee\Cygnus\Authentication\Operations;

use SudoBee\Cygnus\Core\Utilities\Notification;
use SudoBee\Cygnus\Form\Operation;
use SudoBee\Cygnus\Form\Traits\HasStore;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Throwable;

class SendEmailVerificationOperation extends Operation
{
	use HasStore;

	public function route(): string
	{
		return "/auth/email/send";
	}

	/**
	 * @throws Throwable
	 */
	public function handle(object $validated)
	{
		$throttleKey = Str::lower(
			"send-email-verification|" . $this->store->user->id
		);

		$isRateLimitReached = RateLimiter::tooManyAttempts($throttleKey, 1);
		if ($isRateLimitReached) {
			Notification::danger(
				trans("auth.throttle", [
					"seconds" => RateLimiter::availableIn($throttleKey),
				])
			);

			return redirect()->back();
		}

		$this->store->user->sendEmailVerificationNotification();

		RateLimiter::hit($throttleKey);
		Notification::success(
			"Verification email has been sent. Please check your inbox."
		);

		return redirect()->back();
	}
}
