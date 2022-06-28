<?php

namespace Arpite\Arpite\Tests\Unit\Component\Components\Table\Cells;

use Arpite\Arpite\Component\Components\Table\Cells\TableCell;
use Arpite\Arpite\Component\Components\Table\Enums\StatusImage;
use Exception;
use Arpite\Arpite\Tests\TestCase;

class TableCellTest extends TestCase
{
	/**
	 * @throws Exception
	 */
	public function test_initial_state(): void
	{
		$testTableCell = TableCell::make();

		$this->assertEquals(
			[
				"nodeType" => "TableCell",
				"title" => null,
				"titleLink" => null,
				"description" => null,
				"descriptionLink" => null,
				"image" => null,
			],
			$testTableCell->export()
		);
	}

	/**
	 * @throws Exception
	 */
	public function test_set_title_link(): void
	{
		$testLinkColumn = TableCell::make()->setTitleLink("https://fun.fun");

		$this->assertEquals(
			[
				"nodeType" => "TableCell",
				"title" => null,
				"titleLink" => "https://fun.fun",
				"description" => null,
				"descriptionLink" => null,
				"image" => null,
			],
			$testLinkColumn->export()
		);
	}

	/**
	 * @throws Exception
	 */
	public function test_set_description_link(): void
	{
		$testLinkColumn = TableCell::make()->setDescriptionLink(
			"https://description.fun"
		);

		$this->assertEquals(
			[
				"nodeType" => "TableCell",
				"title" => null,
				"titleLink" => null,
				"description" => null,
				"descriptionLink" => "https://description.fun",
				"image" => null,
			],
			$testLinkColumn->export()
		);
	}

	/**
	 * @throws Exception
	 */
	public function test_set_image_using_status_image(): void
	{
		$testLinkColumn = TableCell::make()->setImage(StatusImage::GREEN);

		$this->assertEquals(
			[
				"nodeType" => "TableCell",
				"title" => null,
				"titleLink" => null,
				"description" => null,
				"descriptionLink" => null,
				"image" => "GREEN",
			],
			$testLinkColumn->export()
		);
	}

	/**
	 * @throws Exception
	 */
	public function test_as_activity_indicator(): void
	{
		$testLinkColumn = TableCell::make();

		$testLinkColumn->asActivityIndicator(true);
		$this->assertEquals(
			[
				"nodeType" => "TableCell",
				"title" => "Enabled",
				"titleLink" => null,
				"description" => null,
				"descriptionLink" => null,
				"image" => "PING_GREEN",
			],
			$testLinkColumn->export()
		);

		$testLinkColumn->asActivityIndicator(false);
		$this->assertEquals(
			[
				"nodeType" => "TableCell",
				"title" => "Disabled",
				"titleLink" => null,
				"description" => null,
				"descriptionLink" => null,
				"image" => "RED",
			],
			$testLinkColumn->export()
		);
	}

	/**
	 * @throws Exception
	 */
	public function test_all_combined(): void
	{
		$testLinkColumn = TableCell::make()
			->setDescription("No joke")
			->setTitleLink("https://fun2.fun")
			->setDescriptionLink("https://description2.fun");

		$this->assertEquals(
			[
				"nodeType" => "TableCell",
				"title" => null,
				"titleLink" => "https://fun2.fun",
				"description" => "No joke",
				"descriptionLink" => "https://description2.fun",
				"image" => null,
			],
			$testLinkColumn->export()
		);
	}
}
