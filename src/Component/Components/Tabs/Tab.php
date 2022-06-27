<?php

namespace SudoBee\Cygnus\Component\Components\Tabs;

use SudoBee\Cygnus\Component\Component;
use SudoBee\Cygnus\Component\Traits\HasActions;
use SudoBee\Cygnus\Component\Traits\HasNodes;
use SudoBee\Cygnus\Core\Utilities\ExportBuilder;

class Tab extends Component
{
	use HasNodes;
	use HasActions;

	private string $title;

	private bool $primary = false;

	private ?string $icon = null;

	private ?int $count = null;

	private ?string $link = null;

	private function __construct(string $title)
	{
		$this->title = $title;
	}

	public static function make(string $title): self
	{
		return new self($title);
	}

	public function setIcon(?string $icon): self
	{
		$this->icon = $icon;

		return $this;
	}

	public function setCount(?int $count): self
	{
		$this->count = $count;

		return $this;
	}

	public function setLink(?string $link): self
	{
		$this->link = $link;

		return $this;
	}

	public function isPrimary(bool $primary = true): self
	{
		$this->primary = $primary;

		return $this;
	}

	/**
	 * @return array<string, mixed>
	 */
	public function export(): array
	{
		return ExportBuilder::make($this)
			->mergeProperties($this->nodesExport())
			->mergeProperties($this->actionsExport())
			->addProperty("title", __($this->title))
			->addProperty("icon", $this->icon)
			->addProperty("count", $this->count)
			->addProperty("link", $this->link)
			->addProperty("primary", $this->primary)
			->export();
	}
}
