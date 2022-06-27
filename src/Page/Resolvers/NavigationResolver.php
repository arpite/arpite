<?php

namespace SudoBee\Cygnus\Page\Resolvers;

use SudoBee\Cygnus\Page\Objects\NavigationItem;

class NavigationResolver
{
	/**
	 * @param array<int, NavigationItem> $navigationItems
	 */
	public function __construct(private readonly array $navigationItems = [])
	{
		//
	}

	/**
	 * @param array<int, NavigationItem> $navigationItems
	 * @return self
	 */
	public static function make(array $navigationItems = []): self
	{
		return new self($navigationItems);
	}

	/**
	 * @return array<int, NavigationItem>
	 */
	public function getNavigationItems(): array
	{
		return $this->navigationItems;
	}
}
