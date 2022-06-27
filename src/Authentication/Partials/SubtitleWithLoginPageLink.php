<?php

namespace SudoBee\Cygnus\Authentication\Partials;

use SudoBee\Cygnus\Component\Components\Link\Link;
use SudoBee\Cygnus\Component\Components\Text;

class SubtitleWithLoginPageLink
{
	public static function make(): Text
	{
		return Text::make(
			"Or ",
			Link::make()
				->setTitle("login to existing account")
				->setLink(route("login"))
		);
	}
}
