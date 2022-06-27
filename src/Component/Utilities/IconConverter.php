<?php

namespace SudoBee\Cygnus\Component\Utilities;

use Illuminate\Support\Str;

class IconConverter
{
	public static function toDataUrl(
		string $icon,
		string $color = "#d1d5db"
	): string {
		// Need to encode hashtag
		$color = Str::of($color)->replaceFirst("#", "%23");

		return "data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' style='width:24px;height:24px;color:$color' viewBox='0 0 24 24'%3E%3Cpath fill='currentColor' d='$icon' /%3E%3C/svg%3E";
	}
}
