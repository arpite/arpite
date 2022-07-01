<?php

namespace Arpite\Core\Middlewares;

use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleArpiteRequests extends Middleware
{
	/** @var string */
	protected $rootView = "arpite::application";

	/**
	 * @param Request $request
	 * @return array<int, mixed>
	 */
	public function share(Request $request): array
	{
		/** @var User|null $user */
		$user = auth()->check() ? auth()->user() : null;

		return array_merge(parent::share($request), [
			"user" => $user?->only("email", "name"),
		]);
	}
}
