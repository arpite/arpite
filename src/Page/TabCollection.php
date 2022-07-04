<?php

namespace Arpite\Page;

use Arpite\Component\Components\Tabs\Enums\TabsDesign;
use Arpite\Core\Traits\HasRegisterRoutes;

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
