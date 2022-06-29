<?php

namespace Arpite\Authentication\Partials;

use Arpite\Component\Components\Link\Link;
use Arpite\Component\Components\Text;

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
