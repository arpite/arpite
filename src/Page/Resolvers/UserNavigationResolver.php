<?php

namespace SudoBee\Cygnus\Page\Resolvers;

use SudoBee\Cygnus\Authentication\Pages\AuthenticationPages;
use SudoBee\Cygnus\Authentication\Pages\UserEditPage;
use SudoBee\Cygnus\Page\Objects\UserNavigationItem;

class UserNavigationResolver
{
	/**
	 * @param array<int, UserNavigationItem> $navigationItems
	 */
	public function __construct(private readonly array $navigationItems = [])
	{
		//
	}

	/**
	 * @param array<int, UserNavigationItem> $navigationItems
	 * @return self
	 */
	public static function make(array $navigationItems = []): self
	{
		return new self($navigationItems);
	}

	/**
	 * @return array<int, UserNavigationItem>
	 */
	public function getNavigationItems(): array
	{
		if (AuthenticationPages::isUserEditPageEnabled()) {
			return [
				UserNavigationItem::fromPage(UserEditPage::class),
				...$this->navigationItems,
			];
		}

		return $this->navigationItems;
	}
}
