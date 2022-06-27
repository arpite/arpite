<?php

namespace SudoBee\Cygnus\Tests\Unit\Page;

use SudoBee\Cygnus\Page\TabCollection;
use SudoBee\Cygnus\Tests\Unit\Component\TestComponent;

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
