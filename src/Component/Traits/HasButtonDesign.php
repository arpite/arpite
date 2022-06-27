<?php

namespace SudoBee\Cygnus\Component\Traits;

use SudoBee\Cygnus\Component\Components\Button\Enums\ButtonDesign;
use SudoBee\Cygnus\Core\Utilities\ExportBuilder;

trait HasButtonDesign
{
	private string $design = ButtonDesign::PRIMARY;

	/**
	 * @return static
	 */
	public function asPrimary()
	{
		$this->design = ButtonDesign::PRIMARY;

		return $this;
	}

	/**
	 * @return static
	 */
	public function asSecondary()
	{
		$this->design = ButtonDesign::SECONDARY;

		return $this;
	}

	/**
	 * @return static
	 */
	public function asSecondaryWithBorder()
	{
		$this->design = ButtonDesign::SECONDARY_WITH_BORDER;

		return $this;
	}

	/**
	 * @return static
	 */
	public function asTernary()
	{
		$this->design = ButtonDesign::TERNARY;

		return $this;
	}

	/**
	 * @return array<mixed>
	 */
	private function buttonDesignExport(): array
	{
		return ExportBuilder::make()
			->addProperty("design", $this->design)
			->export();
	}
}
