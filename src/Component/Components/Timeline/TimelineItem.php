<?php

namespace SudoBee\Cygnus\Component\Components\Timeline;

use Carbon\CarbonImmutable;
use SudoBee\Cygnus\Component\Component;
use SudoBee\Cygnus\Component\Traits\HasDescription;
use SudoBee\Cygnus\Component\Traits\HasTitle;
use SudoBee\Cygnus\Core\Utilities\ExportBuilder;

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
