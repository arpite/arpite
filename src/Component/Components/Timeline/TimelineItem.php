<?php

namespace Arpite\Component\Components\Timeline;

use Carbon\CarbonImmutable;
use Arpite\Component\Component;
use Arpite\Component\Traits\HasDescription;
use Arpite\Component\Traits\HasTitle;
use Arpite\Core\Utilities\ExportBuilder;

class TimelineItem extends Component
{
	use HasTitle;
	use HasDescription;

	private ?CarbonImmutable $date = null;

	public static function make(): self
	{
		return new self();
	}

	/**
	 * @param CarbonImmutable|null $date
	 * @return static
	 */
	public function setDate(?CarbonImmutable $date)
	{
		$this->date = $date;

		return $this;
	}

	/**
	 * @return array<mixed>
	 */
	public function export(): array
	{
		return ExportBuilder::make($this)
			->mergeProperties($this->titleExport())
			->mergeProperties($this->descriptionExport())
			->addProperty("date", $this->date)
			->export();
	}
}
