<?php

namespace SudoBee\Cygnus\Component\Components\Link;

use SudoBee\Cygnus\Component\ButtonTemplate;
use SudoBee\Cygnus\Component\Traits\HasTextAlign;
use SudoBee\Cygnus\Core\Utilities\ExportBuilder;
use Exception;

class Link extends ButtonTemplate
{
	use HasTextAlign;

	public static function make(): self
	{
		return new self();
	}

	/**
	 * @return array<string, mixed>
	 * @throws Exception
	 */
	public function export(): array
	{
		return ExportBuilder::make($this)
			->mergeProperties($this->textAlignExport())
			->mergeProperties($this->buttonTemplateExport())
			->export();
	}
}
