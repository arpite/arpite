<?php

namespace Arpite\Arpite\Layout\Layouts;

use Arpite\Arpite\Core\Utilities\ExportBuilder;
use Arpite\Arpite\Layout\Layout;

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
