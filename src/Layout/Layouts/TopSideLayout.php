<?php

namespace Arpite\Layout\Layouts;

use Arpite\Core\Utilities\ExportBuilder;
use Arpite\Layout\Layout;

class TopSideLayout extends Layout
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
