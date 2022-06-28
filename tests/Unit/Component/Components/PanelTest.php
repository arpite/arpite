<?php

namespace Arpite\Arpite\Tests\Unit\Component\Components;

use Arpite\Arpite\Component\Components\Panel;
use Arpite\Arpite\Tests\TestCase;

class PanelTest extends TestCase
{
	public function test_initial_state(): void
	{
		$testPanel = Panel::make();

		$this->assertEquals(
			[
				"nodeType" => "Panel",
				"nodes" => [],
				"actions" => [],
				"title" => null,
				"description" => null,
				"padding" => 6,
			],
			$testPanel->export()
		);
	}
}

it("can change padding", function () {
	$testPanel = Panel::make();

	expect($testPanel->export())->toHaveKey("padding", 6);

	$testPanel->setPadding(10);
	expect($testPanel->export())->toHaveKey("padding", 10);
});
