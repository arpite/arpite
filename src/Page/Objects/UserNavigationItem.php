<?php

namespace SudoBee\Cygnus\Page\Objects;

use SudoBee\Cygnus\Component\Traits\HasTitle;
use SudoBee\Cygnus\Core\Interfaces\Exportable;
use SudoBee\Cygnus\Core\Utilities\ExportBuilder;
use SudoBee\Cygnus\Page\Page;

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
