<?php

namespace Arpite\Authentication\Jobs;

use Domain\Team\Models\User;
use Illuminate\Auth\Passwords\PasswordBroker;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendResetPasswordMailJob implements ShouldQueue
{
	use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

	public function __construct(private string $userId)
	{
	}

	public function handle(): void
	{
		/** @var User $user */
		$user = User::findOrFail($this->userId);

		$token = app(PasswordBroker::class)->createToken($user);

		$user->sendPasswordResetNotification($token);
	}
}
