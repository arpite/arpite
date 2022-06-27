<?php

namespace SudoBee\Cygnus\Layout\Layouts;

use SudoBee\Cygnus\Component\Components\Text;
use SudoBee\Cygnus\Component\Traits\HasTitle;
use SudoBee\Cygnus\Core\Utilities\ExportBuilder;
use SudoBee\Cygnus\Layout\Layout;

class CentralLayout extends Layout
{
	use HasTitle;

	private bool $showLogo = true;

	/** @var Text|null $subtitle */
	private ?Text $subtitle = null;

	public static function make(): self
	{
		return new self();
	}

	/**
	 * @param string|null|Text $subtitle
	 * @return static
	 */
	public function setSubtitle(string|null|Text $subtitle)
	{
		$this->subtitle = Text::make($subtitle);

		return $this;
	}

	/**
	 * @return static
	 */
	public function hideLogo()
	{
		$this->showLogo = false;

		return $this;
	}

	/**
	 * @return array<string, mixed>
	 */
	public function export(): array
	{
		return ExportBuilder::make($this)
			->mergeProperties($this->titleExport())
			->addProperty("subtitle", $this->subtitle)
			->addProperty("showLogo", $this->showLogo)
			->export();
	}
}
