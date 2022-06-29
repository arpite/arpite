<?php

namespace Arpite\Component\Components;

use Arpite\Component\Component;
use Arpite\Component\Enums\Icon;
use Arpite\Component\Traits\HasButtons;
use Arpite\Component\Traits\HasDescription;
use Arpite\Component\Traits\HasIcon;
use Arpite\Core\Utilities\ExportBuilder;

class AlertBanner extends Component
{
	use HasDescription;
	use HasButtons;
	use HasIcon;

	public function __construct()
	{
		$this->setIcon(Icon::INFORMATION);
	}

	public static function make(): self
	{
		return new self();
	}

	/**
	 * @return array<string, mixed>
	 */
	public function export(): array
	{
		return ExportBuilder::make($this)
			->mergeProperties($this->iconExport())
			->mergeProperties($this->descriptionExport())
			->mergeProperties($this->buttonsExport())
			->export();
	}
}
