<?php

namespace Arpite\Arpite\Tests\Unit\Component\Traits\HasButtonDesign;

use Arpite\Arpite\Tests\TestCase;

const COMPONENT_EXPORT = [
	"nodeType" => "TestComponentWithHasButtonDesignTrait",
	"design" => "primary",
];

class HasButtonDesignTest extends TestCase
{
	public function test_initial_state(): void
	{
		$testComponent = new TestComponentWithHasButtonDesignTrait();

		$this->assertEquals(COMPONENT_EXPORT, $testComponent->export());
	}

	public function test_change_design(): void
	{
		$testComponent = new TestComponentWithHasButtonDesignTrait();

		$testComponent->asSecondary();
		$this->assertEquals(
			array_merge(COMPONENT_EXPORT, [
				"design" => "secondary",
			]),
			$testComponent->export()
		);

		$testComponent->asSecondaryWithBorder();
		$this->assertEquals(
			array_merge(COMPONENT_EXPORT, [
				"design" => "secondary-with-border",
			]),
			$testComponent->export()
		);

		$testComponent->asTernary();
		$this->assertEquals(
			array_merge(COMPONENT_EXPORT, [
				"design" => "ternary",
			]),
			$testComponent->export()
		);

		$testComponent->asPrimary();
		$this->assertEquals(
			array_merge(COMPONENT_EXPORT, [
				"design" => "primary",
			]),
			$testComponent->export()
		);
	}
}
