<?php

namespace Arpite\Arpite\Component\Traits;

use Arpite\Arpite\Component\Component;
use Arpite\Arpite\Core\Utilities\ExportBuilder;

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
