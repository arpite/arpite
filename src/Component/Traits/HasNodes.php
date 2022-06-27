<?php

namespace SudoBee\Cygnus\Component\Traits;

use SudoBee\Cygnus\Component\Component;
use SudoBee\Cygnus\Core\Utilities\ExportBuilder;

trait HasNodes
{
	/**
	 * @var Component[]
	 */
	private array $nodes = [];

	/**
	 * @param Component[] $nodes
	 * @return static
	 */
	public function setNodes(array $nodes)
	{
		$this->nodes = $nodes;

		return $this;
	}

	/**
	 * @return Component[]
	 */
	public function getNodes(): array
	{
		return $this->nodes;
	}

	/**
	 * @return array<mixed>
	 */
	private function nodesExport(): array
	{
		return ExportBuilder::make()
			->addNodesProperty("nodes", $this->nodes)
			->export();
	}
}
