<?php

namespace SudoBee\Cygnus\Component\Components;

use SudoBee\Cygnus\Component\Component;
use SudoBee\Cygnus\Component\Enums\Icon;
use SudoBee\Cygnus\Component\Traits\HasButtons;
use SudoBee\Cygnus\Component\Traits\HasDescription;
use SudoBee\Cygnus\Component\Traits\HasIcon;
use SudoBee\Cygnus\Core\Utilities\ExportBuilder;

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
