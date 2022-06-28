<?php

namespace Arpite\Arpite\Tests\Unit\Component\Components;

use Arpite\Arpite\Component\Components\Image;
use Arpite\Arpite\Tests\TestCase;

class ImageTest extends TestCase
{
	public function test_initial_state(): void
	{
		$testImage = Image::make("https://bit.ly/3628MGk", "This is image alt");

		$this->assertEquals(
			[
				"nodeType" => "Image",
				"src" => "https://bit.ly/3628MGk",
				"alt" => "This is image alt",
			],
			$testImage->export()
		);
	}
}
