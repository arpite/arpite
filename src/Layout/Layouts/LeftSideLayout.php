<?php

namespace SudoBee\Cygnus\Layout\Layouts;

use SudoBee\Cygnus\Core\Utilities\ExportBuilder;
use SudoBee\Cygnus\Layout\Layout;

class LeftSideLayout extends Layout
{
	public static function make(): self
	{
		return new self();
	}

	/**
	 * @return array<string, mixed>
	 */
	public function export(): array
	{
		return ExportBuilder::make($this)->export();
	}
}
