<?php

namespace SudoBee\Cygnus\Component\Components\Card;

use SudoBee\Cygnus\Component\Component;
use SudoBee\Cygnus\Component\Components\Card\Enums\CardDesignEnum;
use SudoBee\Cygnus\Component\Traits\HasButtons;
use SudoBee\Cygnus\Component\Traits\HasDescription;
use SudoBee\Cygnus\Component\Traits\HasImage;
use SudoBee\Cygnus\Component\Traits\HasTitle;
use SudoBee\Cygnus\Core\Utilities\ExportBuilder;

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
