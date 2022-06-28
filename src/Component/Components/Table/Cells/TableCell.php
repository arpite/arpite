<?php

namespace Arpite\Arpite\Component\Components\Table\Cells;

use Arpite\Arpite\Component\Component;
use Arpite\Arpite\Component\Components\Table\Enums\StatusImage;
use Arpite\Arpite\Component\Traits\HasDescription;
use Arpite\Arpite\Component\Traits\HasImage;
use Arpite\Arpite\Component\Traits\HasTitle;
use Arpite\Arpite\Core\Utilities\ExportBuilder;

class TableCell extends Component
{
	use HasTitle;
	use HasDescription;
	use HasImage;

	private ?string $titleLink = null;

	private ?string $descriptionLink = null;

	public static function make(): self
	{
		return new self();
	}

	public function setTitleLink(?string $titleLink): self
	{
		$this->titleLink = $titleLink;

		return $this;
	}

	public function setDescriptionLink(?string $descriptionLink): self
	{
		$this->descriptionLink = $descriptionLink;

		return $this;
	}

	public function asActivityIndicator(bool $active): self
	{
		return $this->setTitle(
			/** @phpstan-ignore-next-line */
			$active ? __("Enabled") : __("Disabled")
		)->setImage($active ? StatusImage::PING_GREEN : StatusImage::RED);
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
			->addProperty("titleLink", $this->titleLink)
			->addProperty("descriptionLink", $this->descriptionLink)
			->export();
	}
}
