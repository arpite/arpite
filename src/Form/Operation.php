<?php

namespace Arpite\Form;

use Arpite\Core\Traits\HasRegisterRoutes;
use Arpite\Core\Traits\HasResolveHelpers;
use Arpite\Core\Utilities\Notification;
use Arpite\Core\Utilities\RouteUtility;
use Arpite\Form\Actions\IsInertiaRequestAction;
use Arpite\Form\Enums\OperationResponseType;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Throwable;

abstract class Operation
{
	use HasRegisterRoutes;
	use HasResolveHelpers;

	/** @var array<string, string> $parameters */
	protected array $parameters = [];

	protected string $responseType = OperationResponseType::REGULAR;

	public function __construct()
	{
		if (method_exists($this, "initStore")) {
			$this->initStore();
		}
	}

	abstract public function route(): string;

	/**
	 * @param object $validated
	 * @return mixed
	 */
	abstract public function handle(object $validated);

	/**
	 * @param object $validated
	 * @return mixed
	 */
	protected function callHandle(object $validated)
	{
		return $this->handle($validated);
	}

	/**
	 * @param Request $request
	 * @return array<mixed>
	 * @throws ValidationException
	 */
	protected function validate(Request $request): array
	{
		return [];
	}

	final protected function updateStore(): void
	{
		if (property_exists($this, "store")) {
			$this->store->update();
		}
	}

	public function authorize(): bool
	{
		return true;
	}

	/**
	 * @param Request $request
	 * @return mixed
	 * @throws Throwable
	 * @throws ValidationException
	 */
	public function handleRequest(Request $request)
	{
		$this->updateStore();

		$isInertiaRequest = app(IsInertiaRequestAction::class)->execute(
			$request
		);

		if (!$this->authorize()) {
			Notification::danger("You do not have permission for that.");

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

		$validated = $this->validate($request);

		$response = $this->callHandle((object) $validated);

		if ($isInertiaRequest) {
			return $response;
		}

		return response()->json([
			"success" => true,
			"data" => $response,
			"errors" => null,
			"notification" => Notification::getAndClear(),
		]);
	}

	public function getResponseType(): string
	{
		return $this->responseType;
	}

	/**
	 * @param array<string, string> $parameters
	 * @return string
	 */
	public static function link(array $parameters = []): string
	{
		$className = get_called_class();

		/** @var Operation $operation */
		/** @phpstan-ignore-next-line */
		$operation = new $className();

		$route = $operation->route();

		foreach ($parameters as $key => $value) {
			$route = (string) Str::of($route)->replace(
				"{" . $key . "}",
				$value
			);
		}

		return $route;
	}

	public function registerRoutes(): void
	{
		RouteUtility::post(
			$this->route(),
			fn(Request $request) => $this->handleRequest($request)
		);
	}
}
