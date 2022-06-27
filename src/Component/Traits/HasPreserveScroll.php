<?php

namespace SudoBee\Cygnus\Component\Traits;

use SudoBee\Cygnus\Core\Utilities\ExportBuilder;

trait HasPreserveScroll
{
	private bool $preserveScroll = false;

	/**
	 * @param bool $preserveScroll
	 * @return static
	 */
	public function setPreserveScroll(bool $preserveScroll = true)
	{
		$this->preserveScroll = $preserveScroll;

		return $this;
	}

	/**
	 * @return array<string, mixed>
	 */
	private function preserveScrollExport(): array
	{
		return ExportBuilder::make()
			->addProperty("preserveScroll", $this->preserveScroll)
			->export();
	}
}
