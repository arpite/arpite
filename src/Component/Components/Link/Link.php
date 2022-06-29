<?php

namespace Arpite\Component\Components\Link;

use Arpite\Component\ButtonTemplate;
use Arpite\Component\Traits\HasTextAlign;
use Arpite\Core\Utilities\ExportBuilder;
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
