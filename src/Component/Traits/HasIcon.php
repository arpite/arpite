<?php

namespace Arpite\Component\Traits;

use Arpite\Core\Utilities\ExportBuilder;

trait HasIcon
{
	private ?string $icon = null;

	public function setIcon(?string $icon): self
	{
		$this->icon = $icon;

		return $this;
	}

	/**
	 * @return array<mixed>
	 */
	private function iconExport(): array
	{
		return ExportBuilder::make()
			->addProperty("icon", $this->icon)
			->export();
	}
}
