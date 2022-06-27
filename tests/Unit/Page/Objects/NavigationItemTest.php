<?php

use SudoBee\Cygnus\Page\Objects\NavigationItem;
use SudoBee\Cygnus\Tests\Unit\Page\Page\TestPage;

it("should have initial state", function () {
	$item = NavigationItem::make("/page", "Page");

	expect($item->export())
		->toHaveKey("activeMatch", "/page")
		->toHaveKey("route", "/page")
		->toHaveKey("title", "Page");
});

it("can generate from given page class", function () {
	$item = NavigationItem::fromPage(TestPage::class);

	expect($item->export())
		->toHaveKey("activeMatch", "/test/test-page")
		->toHaveKey("route", "/test/test-page")
		->toHaveKey("title", "Test page title");
});

it("can change active match", function () {
	$item = NavigationItem::make("/page", "Page");
	expect($item->export())->toHaveKey("activeMatch", "/page");

	$item->setActiveMatch("/other-page");
	expect($item->export())->toHaveKey("activeMatch", "/other-page");
	expect($item->export())->not->toHaveKey("page", "/other-page");
});
