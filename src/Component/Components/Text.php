<?php

namespace Arpite\Arpite\Component\Components;

use Arpite\Arpite\Component\Component;
use Arpite\Arpite\Core\Interfaces\Exportable;
use Arpite\Arpite\Core\Utilities\ExportBuilder;

class Text extends Component
{
	/** @var array<int, string|Component> $nodesAndStrings */
	private array $nodesAndStrings;

	private ?string $color = null;

	private function __construct(string|Component|null ...$nodes)
	{
		/** @var array<int, string|Component> $nodesWithoutNull */
		$nodesWithoutNull = array_filter($nodes, fn($node) => $node !== null);

		$this->nodesAndStrings = $nodesWithoutNull;
	}

	public static function make(Text|string|Component|null ...$nodes): self
	{
		if (count($nodes) === 1 && $nodes[0] instanceof Text) {
			return $nodes[0];
		}

		return new self(...$nodes);
	}

	/**
	 * @param string|null $color
	 * @return static
	 */
	public function setColor(?string $color)
	{
		$this->color = $color;

		return $this;
	}

	/**
	 * @return array<int, mixed>
	 */
	private function getExportedNodesAndStrings(): array
	{
		return array_values(
			array_map(
				/**
				 * @param string|Component $nodeOrString
				 * @return array<int, mixed>|string
				 */
				function (string|Component $nodeOrString) {
					if ($nodeOrString instanceof Exportable) {
						return $nodeOrString->export();
					}

					return __($nodeOrString);
				},
				$this->nodesAndStrings
			)
		);
	}

	/**
	 * @return array<mixed>
	 */
	public function export(): array
	{
		$exportedNodesAndStrings = $this->getExportedNodesAndStrings();

		return ExportBuilder::make($this)
			->addProperty("nodesAndStrings", $exportedNodesAndStrings)
			->addProperty("color", $this->color)
			->export();
	}
}
