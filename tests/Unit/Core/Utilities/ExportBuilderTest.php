<?php

namespace Arpite\Tests\Unit\Core\Utilities;

use Arpite\Core\Utilities\ExportBuilder;
use Arpite\Tests\TestCase;
use Arpite\Tests\Unit\Component\TestComponent;

class ExportBuilderTest extends TestCase
{
	public function test_passing_component_generates_proper_type_array(): void
	{
		$testComponent = new TestComponent();

		$this->assertEquals(
			["nodeType" => "TestComponent"],
			ExportBuilder::make($testComponent)->export()
		);
	}

	public function test_passing_no_arguments_to_make_exports_empty_array(): void
	{
		$this->assertEquals([], ExportBuilder::make()->export());
	}

	public function test_adding_properties(): void
	{
		$this->assertEquals(
			["hello" => "World"],
			ExportBuilder::make()
				->addProperty("hello", "World")
				->export()
		);
	}

	public function test_adding_component_array_properties(): void
	{
		$this->assertEquals(
			[
				"children" => [
					["nodeType" => "TestComponent"],
					["nodeType" => "TestComponent"],
				],
			],
			ExportBuilder::make()
				->addNodesProperty("children", [
					new TestComponent(),
					new TestComponent(),
				])
				->export()
		);
	}

	public function test_merging_properties(): void
	{
		$this->assertEquals(
			[
				"hello" => "world",
				"world" => "hello",
			],
			ExportBuilder::make()
				->addProperty("hello", "world")
				->mergeProperties([
					"world" => "hello",
				])
				->export()
		);
	}

	public function test_all_methods_at_once(): void
	{
		$this->assertEquals(
			[
				"hello" => "world",
				"world" => "hello",
				"children" => [
					["nodeType" => "TestComponent"],
					["nodeType" => "TestComponent"],
				],
			],
			ExportBuilder::make()
				->addProperty("hello", "world")
				->mergeProperties(["world" => "hello"])
				->addNodesProperty("children", [
					new TestComponent(),
					new TestComponent(),
				])
				->export()
		);
	}
}

it("can add and export component property", function () {
	expect(
		ExportBuilder::make()
			->addProperty("labelComponent", new TestComponent())
			->export()
	)->toBe([
		"labelComponent" => ["nodeType" => "TestComponent"],
	]);
});

it("should add property when condition is true", function () {
	$builder = ExportBuilder::make();
	expect($builder->export())->toBe([]);

	$builder->addPropertyIf(true, "apple", 2);
	expect($builder->export())->toBe([
		"apple" => 2,
	]);

	$builder->addPropertyIf(false, "banana", 5);
	expect($builder->export())->toBe([
		"apple" => 2,
	]);
});
