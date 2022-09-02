<?php

namespace Arpite\Component\Traits;

use Arpite\Component\Component;
use Arpite\Core\Utilities\ExportBuilder;

trait HasActions
{
	/** @var array<int, Component> $actions */
	private array $actions = [];

	/**
	 * @param array<int, Component|null|bool> $actions
	 * @return static
	 */
	public function setActions(array $actions): static
	{
		$this->actions = array_filter(
			$actions,
			fn($node) => $node !== null && $node !== true && $node !== false
		);

		return $this;
	}

	/**
	 * @return array<string, mixed>
	 */
	private function actionsExport(): array
	{
		return ExportBuilder::make()
			->addNodesProperty("actions", $this->actions)
			->export();
	}
}
