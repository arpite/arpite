<?php

namespace Arpite\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Arpite\ArpiteServiceProvider;
use Arpite\Page\Page;
use Database\Seeders\DatabaseSeeder;
use Domain\Integration\Models\Integration;
use Domain\Shop\Actions\CreateShopAction;
use Domain\Shop\Models\Shop;
use Domain\Team\Models\User;
use Illuminate\Support\Facades\Route;
use ReflectionClass;
use ReflectionException;

abstract class TestCase extends Orchestra
{
	protected $loadEnvironmentVariables = true;

	protected function setUp(): void
	{
		parent::setUp();
	}

	/**
	 * @param $app
	 * @return array<int, class-string<PackageServiceProvider>>
	 */
	protected function getPackageProviders($app): array
	{
		return [ArpiteServiceProvider::class];
	}

	/**
	 * @param mixed $object
	 * @param string $property
	 * @return mixed
	 * @throws ReflectionException
	 */
	public function getPrivateProperty($object, string $property)
	{
		$reflectedClass = new ReflectionClass($object);
		$reflection = $reflectedClass->getProperty($property);
		$reflection->setAccessible(true);

		return $reflection->getValue($object);
	}

	public function withUser(): void
	{
		$this->actingAs(User::factory()->create());
	}

	public function getPageProps(Page $page): mixed
	{
		return $page
			->handleRequest()
			->toResponse(request())
			->original->getData()["page"]["props"];
	}

	protected function assertRouteSlugExist(string $slug)
	{
		$this->assertContains(ltrim($slug, "/"), $this->getRouteSlugs());
	}

	protected function assertRouteSlugNotExist(string $slug)
	{
		$this->assertNotContains(ltrim($slug, "/"), $this->getRouteSlugs());
	}

	/**
	 * @return string[]
	 */
	private function getRouteSlugs(): array
	{
		$slugs = [];
		$routes = Route::getRoutes();

		foreach ($routes as $route) {
			$slugs[] = $route->uri();
		}
		return array_unique($slugs);
	}
}
