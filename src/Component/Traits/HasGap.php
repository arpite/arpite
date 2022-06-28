<?php

namespace Arpite\Arpite\Component\Traits;

use Arpite\Arpite\Core\Utilities\ExportBuilder;

trait HasGap
{
	private int $gap = 0;

	/**
	 * @param int<0, 6> $gap
	 * @return static
	 */
	public function setGap(int $gap)
	{
		$this->gap = $gap;

		return $this;
	}

	/**
	 * @return array<mixed>
	 */
	private function gapExport(): array
	{
		return ExportBuilder::make()
			->addProperty("gap", $this->gap)
			->export();
	}
}
