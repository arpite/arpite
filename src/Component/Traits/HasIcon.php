<?php

namespace Arpite\Component\Traits;

use Arpite\Core\Utilities\ExportBuilder;

trait HasIcon
{
	private ?string $icon = null;

	public function setIcon(?string $icon): static
	{
		$this->icon = $icon;

		return $this;
	}

	/**
	 * @return array<string, mixed>
	 */
	private function iconExport(): array
	{
		return ExportBuilder::make()
			->addProperty("icon", $this->icon)
			->export();
	}
}
