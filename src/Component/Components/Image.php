<?php

namespace Arpite\Component\Components;

use Arpite\Component\Component;
use Arpite\Core\Utilities\ExportBuilder;

class Image extends Component
{
	private string $src;

	private string $alt;

	private function __construct(string $src, string $alt)
	{
		$this->src = $src;
		$this->alt = $alt;
	}

	public static function make(string $src, string $alt): self
	{
		return new self($src, $alt);
	}

	/**
	 * @return array<mixed>
	 */
	public function export(): array
	{
		return ExportBuilder::make($this)
			->addProperty("src", $this->src)
			->addProperty("alt", $this->alt)
			->export();
	}
}
