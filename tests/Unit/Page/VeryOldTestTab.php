<?php

namespace Arpite\Tests\Unit\Page;

use Arpite\Page\TabPage;

class VeryOldTestTab extends TabPage
{
	public string $tabCollection = TestTabCollection::class;

	public function count(): ?int
	{
		return 10;
	}

	public function title(): string
	{
		return "Very old test";
	}

	public function route(): string
	{
		return "/test/very-old";
	}

	public function nodes(): array
	{
		return [];
	}

	public function tabTitle(): string
	{
		return "Very old";
	}
}
