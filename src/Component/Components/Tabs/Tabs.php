<?php

namespace SudoBee\Cygnus\Component\Components\Tabs;

use SudoBee\Cygnus\Component\Component;
use SudoBee\Cygnus\Component\Components\Tabs\Enums\TabsDesign;
use SudoBee\Cygnus\Core\Utilities\ExportBuilder;

class Tabs extends Component
{
	private string $design = TabsDesign::REGULAR;

	/**
	 * @var Tab[]
	 */
	private array $tabs = [];

	public static function make(): self
	{
		return new self();
	}

	public function setDesign(string $design): self
	{
		$this->design = $design;

		return $this;
	}

	/**
	 * @param Tab[] $tabs
	 */
	public function setTabs(array $tabs): self
	{
		$this->tabs = $tabs;

		return $this;
	}

	/**
	 * @return array<string, mixed>
	 */
	public function export(): array
	{
		return ExportBuilder::make($this)
			->addNodesProperty("tabs", $this->tabs)
			->addProperty("design", $this->design)
			->export();
	}
}
