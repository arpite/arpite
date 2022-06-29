<?php

use Arpite\Component\Components\Button\Button;
use Arpite\Component\Components\ShopConnectionPanel;
use Domain\Integration\Integrations\WooCommerceIntegration;
use Domain\Integration\Models\Integration;

it("should have initial export", function () {
	expect(
		ShopConnectionPanel::make(
			Integration::where(
				"handler",
				WooCommerceIntegration::class
			)->firstOrFail()
		)->export()
	)->toBe([
		"nodeType" => "ShopConnectionPanel",
		"integrationName" => "WooCommerce",
		"integrationLogoUrl" =>
			env("APP_URL") . "/images/integrations/WooCommerceIntegration.png",
		"permissions" => [
			"Read and update full order information including addresses of your customers",
			"Add and remove shipping zones including all shipping options",
			"Read full information about bought products",
		],
		"acceptButton" => null,
		"permissionsText" => null,
	]);
});

it("can set accept button", function () {
	$shopConnectionPanel = ShopConnectionPanel::make(
		Integration::where(
			"handler",
			WooCommerceIntegration::class
		)->firstOrFail()
	);
	expect($shopConnectionPanel->export())->acceptButton->toBeNull();

	$shopConnectionPanel->setAcceptButton(Button::make()->setTitle("Boo coo"));
	expect($shopConnectionPanel->export())
		->acceptButton->not()
		->toBeNull();
});

it("can set permissions text", function () {
	$shopConnectionPanel = ShopConnectionPanel::make(
		Integration::where(
			"handler",
			WooCommerceIntegration::class
		)->firstOrFail()
	);
	expect($shopConnectionPanel->export())->toHaveKey("permissionsText", null);

	$shopConnectionPanel->setPermissionsText("This is some permissions text.");
	expect($shopConnectionPanel->export())->toHaveKey(
		"permissionsText",
		"This is some permissions text."
	);
});
