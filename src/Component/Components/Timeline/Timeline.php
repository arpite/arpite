<?php

namespace Arpite\Component\Components\Timeline;

use Arpite\Component\Component;
use Arpite\Core\Utilities\ExportBuilder;

class Timeline extends Component
{
	/**
	 * @var TimelineItem[] $timelineItems
	 */
	private array $timelineItems = [];

	public static function make(): self
	{
		return new self();
	}

	/**
	 * @param TimelineItem[] $timelineItems
	 * @return static
	 */
	public function setTimelineItems(array $timelineItems)
	{
		$this->timelineItems = $timelineItems;

		return $this;
	}

	/**
	 * @return array<mixed>
	 */
	public function export(): array
	{
		return ExportBuilder::make($this)
			->addNodesProperty("timelineItems", $this->timelineItems)
			->export();
	}
}
