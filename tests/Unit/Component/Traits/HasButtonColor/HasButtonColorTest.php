<?php

namespace Arpite\Tests\Unit\Component\Traits\HasButtonColor;

use Arpite\Tests\TestCase;

const COMPONENT_EXPORT = [
	"nodeType" => "TestComponentWithHasButtonColorTrait",
	"color" => "primary",
];

class HasButtonColorTest extends TestCase
{
	public function test_initial_state(): void
	{
		$testComponent = new TestComponentWithHasButtonColorTrait();

		$this->assertEquals(COMPONENT_EXPORT, $testComponent->export());
	}

	public function test_set_color(): void
	{
		$testComponent = new TestComponentWithHasButtonColorTrait();

		$testComponent->asColorRed();
		$this->assertEquals(
			array_merge(COMPONENT_EXPORT, [
				"color" => "red",
			]),
			$testComponent->export()
		);

		$testComponent->asColorPrimary();
		$this->assertEquals(
			array_merge(COMPONENT_EXPORT, [
				"color" => "primary",
			]),
			$testComponent->export()
		);

		$testComponent->asColorGray();
		$this->assertEquals(
			array_merge(COMPONENT_EXPORT, [
				"color" => "gray",
			]),
			$testComponent->export()
		);
	}
}
