<?php

namespace Arpite\Arpite\Tests\Unit\Page;

use Arpite\Arpite\Page\TabCollection;
use Arpite\Arpite\Tests\Unit\Component\TestComponent;

class TestTabCollection extends TabCollection
{
	public function title(): string
	{
		return "Fruit tabs collection";
	}

	public function tabs(): array
	{
		return [NewTestTab::class, VeryOldTestTab::class];
	}

	public function actions(): array
	{
		return [new TestComponent()];
	}
}
