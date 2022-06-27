<?php

namespace SudoBee\Cygnus\Form\Actions;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\ValidationException;
use SudoBee\Cygnus\Core\Utilities\Notification;
use Throwable;

class HandleExceptionGracefullyAction
{
	/**
	 * @throws Throwable
	 */
	public function execute(Throwable $throwable): JsonResponse|RedirectResponse
	{
		// TODO: instead of checking if its inertia request,
		//       check if request wants json (header "Accept")
		$isInertiaRequest = app(IsInertiaRequestAction::class)->execute(
			request()
		);

		if ($throwable instanceof ValidationException) {
			if ($isInertiaRequest) {
				/**
				 * Validation exception will be handled
				 * by InertiaJS
				 */
				throw $throwable;
			}

			return response()->json([
				"success" => false,
				"data" => null,
				"errors" => array_map(
					fn($fieldErrors) => $fieldErrors[0],
					$throwable->errors()
				),
				"notification" => Notification::getAndClear(),
			]);
		}

		if (app()->isLocal()) {
			throw $throwable;
		}

		report($throwable);

		Notification::danger(
			"Sorry for inconvenience, please try again later."
		);

		if ($isInertiaRequest) {
			return redirect()->back();
		}

		return response()->json([
			"success" => false,
			"data" => null,
			"errors" => [],
			"notification" => Notification::getAndClear(),
		]);
	}
}
