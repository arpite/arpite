<?php

namespace Arpite\Arpite\Tests\Unit\Component\Components\FilesDisplay;

use Arpite\Arpite\Component\Components\FilesDisplay\FilesDisplay;
use Arpite\Arpite\Tests\TestCase;

const FILES_DISPLAY_COMPONENT_EXPORT = [
	"nodeType" => "FilesDisplay",
	"nodes" => [],
];

class FilesDisplayTest extends TestCase
{
	public function test_initial_state(): void
	{
		$testComponent = FilesDisplay::make();

		$this->assertEquals(
			FILES_DISPLAY_COMPONENT_EXPORT,
			$testComponent->export()
		);
	}
}
