<?php

namespace Arpite\Tests\Unit\Page\Page;

use Arpite\Page\Page;

class TestPage extends Page
{
	public function title(): string
	{
		return "Test page title";
	}

	public function route(): string
	{
		return "/test/test-page";
	}

	public function nodes(): array
	{
		return [];
	}
}
