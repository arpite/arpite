<?php

namespace Arpite\Arpite\Component\Traits;

use Arpite\Arpite\Core\Utilities\ExportBuilder;

trait HasTitle
{
	private ?string $title = null;

	/**
	 * @param string|null $title
	 * @return static
	 */
	public function setTitle(?string $title)
	{
		$this->title = $title;

		return $this;
	}

	/**
	 * @return array<string, mixed>
	 */
	private function titleExport(): array
	{
		return ExportBuilder::make()
			->addProperty("title", __($this->title))
			->export();
	}
}
