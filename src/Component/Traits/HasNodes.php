<?php

namespace Arpite\Component\Traits;

use Arpite\Component\Component;
use Arpite\Core\Utilities\ExportBuilder;

trait HasNodes
{
	/** @var array<int, Component> $nodes */
	private array $nodes = [];

	/**
	 * @param array<int, Component|null|bool> $nodes
	 * @return static
	 */
	public function setNodes(array $nodes): static
	{
		$this->nodes = array_filter(
			$nodes,
			fn($node) => $node !== null && $node !== true && $node !== false
		);

		return $this;
	}

	/**
	 * @return array<int, Component>
	 */
	public function getNodes(): array
	{
		return $this->nodes;
	}

	/**
	 * @return array<string, mixed>
	 */
	private function nodesExport(): array
	{
		return ExportBuilder::make()
			->addNodesProperty("nodes", $this->nodes)
			->export();
	}
}
