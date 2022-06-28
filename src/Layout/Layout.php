<?php

namespace Arpite\Arpite\Layout;

use Arpite\Arpite\Core\Interfaces\Exportable;

abstract class Layout implements Exportable
{
	/**
	 * @return static
	 */
	abstract public static function make();
}
