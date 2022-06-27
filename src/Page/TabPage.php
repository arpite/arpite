<?php

namespace SudoBee\Cygnus\Page;

use SudoBee\Cygnus\Core\Traits\HasResolveHelpers;
use Exception;

abstract class TabPage extends Page
{
	use HasResolveHelpers;

	public string $tabCollection = "";

	public function count(): ?int
	{
		return null;
	}

	public function icon(): ?string
	{
		return null;
	}

	/**
	 * @throws Exception
	 */
	protected function getPageTitle(): string
	{
		return $this->getTabCollection()->title();
	}

	/**
	 * @return string
	 * @throws Exception
	 */
	protected function getTabsDesign(): string
	{
		return $this->getTabCollection()->tabsDesign;
	}

	/**
	 * @return array<int, array{
	 *     title: string,
	 *     count: int|null,
	 *     icon: string|null,
	 *     link: string,
	 *     active: bool
	 * }>
	 * @throws Exception
	 */
	protected function getTabs(): array
	{
		$tabCollection = $this->getTabCollection();

		return array_map(function ($tabPageClass) {
			/** @var TabPage $tabPage */
			$tabPage = new $tabPageClass();

			$isCurrentTab = get_class($tabPage) === get_class($this);

			return [
				"title" => $tabPage->title(),
				"count" => $tabPage->count(),
				"icon" => $tabPage->icon(),
				"link" => $tabPage->resolveRoute(),
				"active" => $isCurrentTab,
			];
		}, $tabCollection->tabs());
	}

	/**
	 * @return TabCollection
	 * @throws Exception
	 */
	private function getTabCollection(): TabCollection
	{
		if ($this->tabCollection === "") {
			throw new Exception(
				"TabPage must declare \$tabsCollection variable"
			);
		}

		/** @var class-string<TabCollection> $tabCollectionClass */
		$tabCollectionClass = $this->tabCollection;

		return new $tabCollectionClass();
	}
}
