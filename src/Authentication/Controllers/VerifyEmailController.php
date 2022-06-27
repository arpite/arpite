<?php

namespace SudoBee\Cygnus\Authentication\Controllers;

use SudoBee\Cygnus\Core\Utilities\Notification;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;

class VerifyEmailController
{
	public function __invoke(
		EmailVerificationRequest $request
	): RedirectResponse {
		$request->fulfill();

		Notification::success("Email has been successfully verified.");

		return redirect()->to("/");
	}
}
