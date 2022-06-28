<?php

namespace Arpite\Arpite\Component\Traits;

use Arpite\Arpite\Core\Utilities\ExportBuilder;

trait HasDisabled
{
	private bool $disabled = false;

	/** @phpstan-ignore-next-line  */
	public function setDisabled(bool $disabled = true): self
	{
		$this->disabled = $disabled;

		return $this;
	}

	/**
	 * @return array<mixed>
	 */
	private function disabledExport(): array
	{
		return ExportBuilder::make()
			->addProperty("disabled", $this->disabled)
			->export();
	}
}
