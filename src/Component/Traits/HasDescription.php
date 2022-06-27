<?php

namespace SudoBee\Cygnus\Component\Traits;

use SudoBee\Cygnus\Core\Utilities\ExportBuilder;

trait HasDescription
{
	private ?string $description = null;

	/**
	 * @param string|null $description
	 * @return static
	 */
	public function setDescription(?string $description)
	{
		$this->description = $description;

		return $this;
	}

	/**
	 * @return array<mixed>
	 */
	private function descriptionExport(): array
	{
		return ExportBuilder::make()
			->addProperty("description", __($this->description))
			->export();
	}
}
