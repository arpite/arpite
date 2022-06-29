<?php

namespace Arpite\Component\Components\Wizard\Partials;

use Closure;
use Arpite\Component\Component;
use Arpite\Component\Traits\HasTitle;
use Arpite\Core\Utilities\ExportBuilder;

class WizardStep extends Component
{
	use HasTitle;

	private bool $active = false;

	private bool $highlighted = false;

	private int $index = 0;

	/**
	 * @var Closure(object): array<mixed> $getStepNodes
	 */
	public Closure $getStepNodes;

	public static function make(): self
	{
		return new self();
	}

	public function setActive(bool $active): self
	{
		$this->active = $active;

		return $this;
	}

	public function setHighlighted(bool $highlighted): self
	{
		$this->highlighted = $highlighted;

		return $this;
	}

	/**
	 * @param Closure(object): array<mixed> $getStepNodes
	 * @return $this
	 */
	public function setGetStepNodes(Closure $getStepNodes): self
	{
		$this->getStepNodes = $getStepNodes;

		return $this;
	}

	/**
	 * Should not be called `getNodes`, because Form
	 * might call that method with that name
	 *
	 * @param object $validated
	 * @return array<mixed>
	 */
	public function getStepNodes(object $validated): array
	{
		return ($this->getStepNodes)($validated);
	}

	public function setIndex(int $index): self
	{
		$this->index = $index;

		return $this;
	}

	/**
	 * @return array<mixed>
	 */
	public function export(): array
	{
		return ExportBuilder::make()
			->mergeProperties($this->titleExport())
			->addProperty("active", $this->active)
			->addProperty("highlighted", $this->highlighted)
			->addProperty("index", $this->index)
			->export();
	}
}
