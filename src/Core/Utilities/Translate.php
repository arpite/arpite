<?php

namespace SudoBee\Cygnus\Core\Utilities;

class Translate
{
	/**
	 * @param  string $text
	 * @param  array<string, mixed> $replace
	 * @param  string|null $locale
	 * @return string
	 */
	public static function text(
		string $text,
		array $replace = [],
		?string $locale = null
	): string {
		return trans($text, $replace, $locale);
	}
}
