<?php

namespace Arpite\Tests\Unit\Component\Components\FilesDisplay;

use Arpite\Component\Components\FilesDisplay\FileItem;
use Arpite\Tests\TestCase;

const FILE_ITEM_COMPONENT_EXPORT = [
	"nodeType" => "FileItem",
	"title" => null,
	"nodes" => [],
];

class FileItemTest extends TestCase
{
	public function test_set_link(): void
	{
		$testComponent = FileItem::make();

		$this->assertEquals(
			FILE_ITEM_COMPONENT_EXPORT,
			$testComponent->export()
		);
	}
}
