<?php

namespace SudoBee\Cygnus\Page\Utilities;

use SudoBee\Cygnus\Form\Operation;
use SudoBee\Cygnus\Page\Page;
use Illuminate\Support\Str;

class Link
{
	/**
	 * @param class-string<Operation|Page> $pageClass
	 * @param array<string, string | number> $parameters
	 * @return string
	 */
	public static function toPage(
		string $pageClass,
		array $parameters = []
	): string {
		/** @var Operation|Page $page */
		$page = new $pageClass();

		$route = $page->route();

		foreach ($parameters as $key => $value) {
			$route = (string) Str::of($route)->replace(
				"{" . $key . "}",
				(string) $value
			);
		}

		return $route;
	}
}
