<?php

namespace Arpite\Component\Traits;

use Arpite\Component\Component;
use Arpite\Core\Utilities\ExportBuilder;

trait HasActions
{
	/**
	 * @var Component[]
	 */
	private array $actions = [];

	/**
	 * @param Component[] $actions
	 */
	public function setActions(array $actions): self
	{
		$this->actions = $actions;

		return $this;
	}

	/**
	 * @return array<mixed>
	 */
	private function actionsExport(): array
	{
		return ExportBuilder::make()
			->addNodesProperty("actions", $this->actions)
			->export();
	}
}
