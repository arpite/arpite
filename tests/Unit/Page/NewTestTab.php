<?php

namespace Arpite\Tests\Unit\Page;

use Arpite\Page\TabPage;

class NewTestTab extends TabPage
{
	public string $tabCollection = TestTabCollection::class;

	public function title(): string
	{
		return "New test";
	}

	public function route(): string
	{
		return "/test/new";
	}

	public function nodes(): array
	{
		return [];
	}

	public function icon(): ?string
	{
		return "icon-svg-goes-here";
	}
}
