<?php

namespace Arpite\Arpite\Authentication\Partials;

use Arpite\Arpite\Component\Components\Link\Link;
use Arpite\Arpite\Component\Components\Text;

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
