<?php

namespace SudoBee\Cygnus\Layout\Layouts\UnauthorizedLayout;

use SudoBee\Cygnus\Component\Components\Text;
use SudoBee\Cygnus\Core\Utilities\ExportBuilder;
use SudoBee\Cygnus\Layout\Layout;
use SudoBee\Cygnus\Layout\Layouts\UnauthorizedLayout\Enums\Width;

class UnauthorizedLayout extends Layout
{
	private ?Text $subtitle = null;

	private string $width = Width::LG;

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
	public function asWidthLG()
	{
		$this->width = Width::LG;

		return $this;
	}

	/**
	 * @return static
	 */
	public function asWidth2XL()
	{
		$this->width = Width::XL2;

		return $this;
	}

	/**
	 * @return array<string, mixed>
	 */
	public function export(): array
	{
		return ExportBuilder::make($this)
			->addProperty("subtitle", $this->subtitle)
			->addProperty("width", $this->width)
			->export();
	}
}
