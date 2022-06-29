<?php

namespace Arpite\Tests\Unit\Page\Page;

use Arpite\Layout\Layout;
use Arpite\Layout\Layouts\CentralLayout;
use Arpite\Layout\Layouts\LeftSideLayout;
use Arpite\Layout\Layouts\TopSideLayout;
use Arpite\Page\Objects\NavigationItem;
use Arpite\Page\Resolvers\LayoutResolver;
use Arpite\Page\Resolvers\NavigationResolver;
use Illuminate\Support\Facades\Route;
use Arpite\Tests\Constants;
use Arpite\Tests\TestCase;
use Arpite\Tests\Unit\Component\TestComponent;
use Arpite\Tests\Unit\Form\Operation\TestOperation;

class PageTest extends TestCase
{
	public function test_should_register_page_route(): void
	{
		$page = new class extends TestPage {
			public function route(): string
			{
				return "/test/favorite-apples";
			}
		};
		$this->assertRouteSlugNotExist("/test/favorite-apples");

		$page::register();
		$this->assertRouteSlugExist("/test/favorite-apples");
	}

	public function test_should_have_title(): void
	{
		$page = new class extends TestPage {
			public function title(): string
			{
				return "Favorite apples";
			}
		};

		$this->assertEquals(
			$this->getPageProps($page)["layoutProperties"]["title"],
			"Favorite apples"
		);
	}

	public function test_should_have_nodes(): void
	{
		$page = new class extends TestPage {
			public function nodes(): array
			{
				return [new TestComponent(), new TestComponent()];
			}
		};

		$this->assertEquals($this->getPageProps($page)["nodes"], [
			Constants::testComponent(),
			Constants::testComponent(),
		]);
	}

	public function test_should_register_operations(): void
	{
		$page = new class extends TestPage {
			public function operations(): array
			{
				return [TestOperation::class];
			}
		};
		$this->assertRouteSlugNotExist("/test/test-operation");

		$page::register();
		$this->assertRouteSlugExist("/test/test-operation");
	}
}

it("should have init response props", function () {
	app()->singleton(NavigationResolver::class, function () {
		return new NavigationResolver([
			NavigationItem::fromPage(TestPage::class)
				->setTitle("Home")
				->setActiveMatch("/"),
		]);
	});

	$page = new TestPage();

	$this->assertEquals($this->getPageProps($page), [
		"baseUrl" => config("app.url"),
		"applicationName" => config("app.name"),
		"notification" => null,
		"csrfToken" => null,
		"resetFormIdentifier" => null,
		"layout" => LeftSideLayout::make()->export(),
		"layoutProperties" => [
			"title" => "Test page title",
			"navigation" => [
				[
					"route" => "/test/test-page",
					"title" => "Home",
					"activeMatch" => "/",
					"icon" => null,
				],
			],
			"tabs" => [],
			"tabsDesign" => null,
		],
		"nodes" => [],
	]);
});

it("can set layout", function () {
	$page = new class extends TestPage {
		public function layout(): Layout
		{
			return CentralLayout::make();
		}
	};

	expect($this->getPageProps($page)["layout"])->toBe(
		CentralLayout::make()->export()
	);
});

it("can change default layout", function () {
	$page = new TestPage();
	$this->app->singleton(LayoutResolver::class, function () {
		return TopSideLayout::make();
	});
	expect($this->getPageProps($page)["layout"])->toBe(
		TopSideLayout::make()->export()
	);

	$this->app->singleton(LayoutResolver::class, function () {
		return CentralLayout::make();
	});
	expect($this->getPageProps($page)["layout"])->toBe(
		CentralLayout::make()->export()
	);
});

it("can set route name", function () {
	expect(Route::has("login"))->toBeTrue();
});
