<?php

namespace SudoBee\Cygnus\Form\Fields\Classes;

use SudoBee\Cygnus\Core\Interfaces\Exportable;
use SudoBee\Cygnus\Core\Utilities\ExportBuilder;

class FileEntity implements Exportable
{
	private function __construct(
		private string|int $identifier,
		private string $title
	) {
		//
	}

	public static function make(string|int $identifier, string $title): self
	{
		return new self(identifier: $identifier, title: $title);
	}

	public function export(): array
	{
		return ExportBuilder::make()
			->addProperty("identifier", $this->identifier)
			->addProperty("title", $this->title)
			->export();
	}
}
