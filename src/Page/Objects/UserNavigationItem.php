<?php

namespace Arpite\Arpite\Page\Objects;

use Arpite\Arpite\Component\Traits\HasTitle;
use Arpite\Arpite\Core\Interfaces\Exportable;
use Arpite\Arpite\Core\Utilities\ExportBuilder;
use Arpite\Arpite\Page\Page;

class UserNavigationItem implements Exportable
{
	use HasTitle;

	private function __construct(private readonly string $route)
	{
		//
	}

	public static function make(string $route): self
	{
		return new self($route);
	}

	/**
	 * @param class-string<Page> $pageClass
	 * @return UserNavigationItem
	 */
	public static function fromPage(string $pageClass): UserNavigationItem
	{
		/** @var Page $page */
		$page = new $pageClass();

		return UserNavigationItem::make($page->route())->setTitle(
			$page->title()
		);
	}

	public function export(): array
	{
		return ExportBuilder::make()
			->mergeProperties($this->titleExport())
			->addProperty("route", $this->route)
			->export();
	}
}
