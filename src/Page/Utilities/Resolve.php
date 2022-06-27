<?php

namespace SudoBee\Cygnus\Page\Utilities;

use SudoBee\Cygnus\Page\Page;
use Illuminate\Support\Str;

class Resolve
{
	/**
	 * @template T
	 * @param T $class
	 * @param string $parameter
	 * @return T
	 */
	public static function model($class, string $parameter)
	{
		$variable = request()->route($parameter);

		/** @phpstan-ignore-next-line  */
		if (is_string($variable) || is_int($variable)) {
			return $class::findOrFail($variable);
		}

		/** @var T $variable */
		return $variable;
	}

	/**
	 * @param string $parameter
	 * @return string
	 */
	public static function string(string $parameter): string
	{
		$variable = request()->route($parameter);

		if ($variable === null) {
			abort(404);
		}

		/** @phpstan-ignore-next-line  */
		return $variable;
	}

	/**
	 * @param string $pageClass
	 * @param array<string, string> $parameters
	 * @return string
	 */
	public static function link(
		string $pageClass,
		array $parameters = []
	): string {
		/** @var Page $page */
		$page = new $pageClass();

		$route = $page->route();

		foreach ($parameters as $key => $value) {
			$route = (string) Str::of($route)->replace(
				"{" . $key . "}",
				$value
			);
		}

		return $route;
	}
}
