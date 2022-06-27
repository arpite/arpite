<?php

namespace SudoBee\Cygnus\Tests\Unit\Component;

use SudoBee\Cygnus\Component\Components\Alert\Alert;
use SudoBee\Cygnus\Component\Components\Modal\Modal;
use SudoBee\Cygnus\Tests\Constants;
use SudoBee\Cygnus\Tests\TestCase;
use SudoBee\Cygnus\Tests\Unit\Page\Page\TestPage;

class ButtonTemplateTest extends TestCase
{
	public function test_initial_state(): void
	{
		$testComponent = new TestButtonTemplateComponent();

		$this->assertEquals(
			[
				"nodeType" => "TestButtonTemplateComponent",
				"title" => null,
				"action" => null,
				"nodesAction" => null,
				"actionAlert" => null,
				"modal" => null,
				"link" => null,
				"blank" => false,
				"type" => "button",
				"color" => "primary",
			],
			$testComponent->export()
		);
	}

	public function test_set_link(): void
	{
		$testComponent = new TestButtonTemplateComponent();

		$testComponent->setLink("/go-to-the-moon");

		$this->assertEquals(
			[
				"nodeType" => "TestButtonTemplateComponent",
				"title" => null,
				"action" => null,
				"nodesAction" => null,
				"actionAlert" => null,
				"modal" => null,
				"link" => "/go-to-the-moon",
				"blank" => false,
				"type" => "button",
				"color" => "primary",
			],
			$testComponent->export()
		);
	}

	public function test_to_page(): void
	{
		$testComponent = new TestButtonTemplateComponent();

		$testComponent->toPage(TestPage::class);

		$this->assertEquals(
			[
				"nodeType" => "TestButtonTemplateComponent",
				"title" => null,
				"action" => null,
				"nodesAction" => null,
				"actionAlert" => null,
				"modal" => null,
				"link" => "/test/test-page",
				"blank" => false,
				"type" => "button",
				"color" => "primary",
			],
			$testComponent->export()
		);
	}

	public function test_blank(): void
	{
		$testComponent = new TestButtonTemplateComponent();

		$testComponent->blank();
		$this->assertEquals(
			[
				"nodeType" => "TestButtonTemplateComponent",
				"title" => null,
				"action" => null,
				"nodesAction" => null,
				"actionAlert" => null,
				"modal" => null,
				"link" => null,
				"blank" => true,
				"type" => "button",
				"color" => "primary",
			],
			$testComponent->export()
		);

		$testComponent->blank(false);
		$this->assertEquals(
			[
				"nodeType" => "TestButtonTemplateComponent",
				"title" => null,
				"action" => null,
				"nodesAction" => null,
				"actionAlert" => null,
				"modal" => null,
				"link" => null,
				"blank" => false,
				"type" => "button",
				"color" => "primary",
			],
			$testComponent->export()
		);
	}

	public function test_set_action_alert(): void
	{
		$testComponent = new TestButtonTemplateComponent();

		$testComponent->setActionConfirm(Alert::make());

		$this->assertEquals(
			[
				"nodeType" => "TestButtonTemplateComponent",
				"title" => null,
				"action" => null,
				"nodesAction" => null,
				"actionAlert" => [
					"nodeType" => "Alert",
					"type" => "DANGER",
					"title" => null,
					"description" => null,
					"confirmButtonText" => "Confirm",
					"cancelButtonText" => "Cancel",
				],
				"modal" => null,
				"link" => null,
				"blank" => false,
				"type" => "button",
				"color" => "primary",
			],
			$testComponent->export()
		);
	}

	public function test_set_nodes_action(): void
	{
		$testComponent = new TestButtonTemplateComponent();

		$testComponent->setNodesAction("/get-new-nodes");

		$this->assertEquals(
			[
				"nodeType" => "TestButtonTemplateComponent",
				"title" => null,
				"action" => null,
				"nodesAction" => "/get-new-nodes",
				"actionAlert" => null,
				"modal" => null,
				"link" => null,
				"blank" => false,
				"type" => "button",
				"color" => "primary",
			],
			$testComponent->export()
		);
	}

	public function test_opens_modal(): void
	{
		$testComponent = new TestButtonTemplateComponent();

		$testComponent->opensModal(Modal::make());

		$this->assertEquals(
			[
				"nodeType" => "TestButtonTemplateComponent",
				"title" => null,
				"action" => null,
				"nodesAction" => null,
				"actionAlert" => null,
				"modal" => Constants::modal(),
				"link" => null,
				"blank" => false,
				"type" => "button",
				"color" => "primary",
			],
			$testComponent->export()
		);
	}
}

it("can change button type", function () {
	$testComponent = new TestButtonTemplateComponent();

	expect($testComponent->export())->toHaveKey("type", "button");

	$testComponent->asSubmit();
	expect($testComponent->export())->toHaveKey("type", "submit");

	$testComponent->asSubmit(false);
	expect($testComponent->export())->toHaveKey("type", "button");
});
