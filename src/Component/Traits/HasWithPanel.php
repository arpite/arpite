<?php

namespace Arpite\Arpite\Component\Traits;

use Arpite\Arpite\Core\Utilities\ExportBuilder;

trait HasWithPanel
{
	protected bool $withPanel = true;

	/** @return static */
	public function withPanel(bool $withPanel = true)
	{
		$this->withPanel = $withPanel;

		return $this;
	}

	/** @return static */
	public function withoutPanel()
	{
		$this->withPanel = false;

		return $this;
	}

	/**
	 * @return array<mixed>
	 */
	private function withPanelExport(): array
	{
		return ExportBuilder::make()
			->addProperty("withPanel", $this->withPanel)
			->export();
	}
}
