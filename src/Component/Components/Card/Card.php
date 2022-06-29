<?php

namespace Arpite\Component\Components\Card;

use Arpite\Component\Component;
use Arpite\Component\Components\Card\Enums\CardDesignEnum;
use Arpite\Component\Traits\HasButtons;
use Arpite\Component\Traits\HasDescription;
use Arpite\Component\Traits\HasImage;
use Arpite\Component\Traits\HasTitle;
use Arpite\Core\Utilities\ExportBuilder;

class Card extends Component
{
	use HasTitle;
	use HasDescription;
	use HasImage;
	use HasButtons;

	private ?string $design = CardDesignEnum::REGULAR;

	public static function make(): self
	{
		return new self();
	}

	/**
	 * @return static
	 */
	public function asRegular()
	{
		$this->design = CardDesignEnum::REGULAR;

		return $this;
	}

	/**
	 * @return static
	 */
	public function asVertical()
	{
		$this->design = CardDesignEnum::VERTICAL;

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
			->mergeProperties($this->imageExport())
			->mergeProperties($this->buttonsExport())
			->addProperty("design", $this->design)
			->export();
	}
}
