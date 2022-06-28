<?php

namespace Arpite\Arpite\Component\Components\Link;

use Arpite\Arpite\Component\ButtonTemplate;
use Arpite\Arpite\Component\Traits\HasTextAlign;
use Arpite\Arpite\Core\Utilities\ExportBuilder;
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
