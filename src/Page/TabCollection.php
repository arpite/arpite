<?php

namespace SudoBee\Cygnus\Page;

use SudoBee\Cygnus\Core\Traits\HasRegisterRoutes;
use SudoBee\Cygnus\Page\Enums\TabsDesign;

abstract class TabCollection
{
	use HasRegisterRoutes;

	public string $tabsDesign = TabsDesign::REGULAR;

	abstract public function title(): string;

	/**
	 * @return array<int, class-string<TabPage>>
	 */
	abstract public function tabs(): array;

	public function registerRoutes(): void
	{
		foreach ($this->tabs() as $tabClass) {
			$tabClass::register();
		}
	}
}
