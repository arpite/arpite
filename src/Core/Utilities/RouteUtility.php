<?php

namespace Arpite\Arpite\Core\Utilities;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Arpite\Arpite\Core\Enums\RouteMethod;
use Arpite\Arpite\Form\Actions\HandleExceptionGracefullyAction;
use Throwable;

class RouteUtility
{
	/**
	 * @param string $uri
	 * @param callable(Request): mixed $callback
	 * @return \Illuminate\Routing\Route
	 */
	public static function get(
		string $uri,
		callable $callback
	): \Illuminate\Routing\Route {
		return self::register(RouteMethod::GET, $uri, $callback);
	}

	/**
	 * @param string $uri
	 * @param callable(Request): mixed $callback
	 * @return \Illuminate\Routing\Route
	 */
	public static function post(
		string $uri,
		callable $callback
	): \Illuminate\Routing\Route {
		return self::register(RouteMethod::POST, $uri, $callback);
	}

	/**
	 * @param RouteMethod $method
	 * @param string $uri
	 * @param callable(Request): mixed $callback
	 * @return \Illuminate\Routing\Route
	 */
	private static function register(
		RouteMethod $method,
		string $uri,
		callable $callback
	): \Illuminate\Routing\Route {
		if ($method === RouteMethod::GET) {
			return Route::get(
				$uri,
				fn(Request $request) => self::wrapCallback($request, $callback)
			);
		}

		return Route::post(
			$uri,
			fn(Request $request) => self::wrapCallback($request, $callback)
		);
	}

	/**
	 * @param Request $request
	 * @param callable(Request): mixed $callback
	 * @return mixed
	 */
	private static function wrapCallback(
		Request $request,
		callable $callback
	): mixed {
		try {
			return $callback($request);
		} catch (Throwable $throwable) {
			return app(HandleExceptionGracefullyAction::class)->execute(
				$throwable
			);
		}
	}
}
