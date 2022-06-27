<?php

namespace SudoBee\Cygnus\Layout;

use SudoBee\Cygnus\Core\Interfaces\Exportable;

abstract class Layout implements Exportable
{
	/**
	 * @return static
	 */
	abstract public static function make();
}
