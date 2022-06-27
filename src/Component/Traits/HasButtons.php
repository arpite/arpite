<?php

namespace SudoBee\Cygnus\Component\Traits;

use SudoBee\Cygnus\Component\ButtonTemplate;
use SudoBee\Cygnus\Core\Utilities\ExportBuilder;

trait HasButtons
{
	/**
	 * @var ButtonTemplate[]
	 */
	private array $buttons = [];

	/**
	 * @param ButtonTemplate[] $buttons
	 * @return static
	 */
	public function setButtons(array $buttons)
	{
		$this->buttons = $buttons;

		return $this;
	}

	/**
	 * @return array<mixed>
	 */
	private function buttonsExport(): array
	{
		return ExportBuilder::make()
			->addNodesProperty("buttons", $this->buttons)
			->export();
	}
}
