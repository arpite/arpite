<?php

namespace SudoBee\Cygnus\Page;

use SudoBee\Cygnus\Component\Component;
use SudoBee\Cygnus\Core\Traits\HasRegisterRoutes;
use SudoBee\Cygnus\Core\Traits\HasResolveHelpers;
use SudoBee\Cygnus\Core\Utilities\ExportBuilder;
use SudoBee\Cygnus\Core\Utilities\RouteUtility;
use SudoBee\Cygnus\Form\Operation;
use SudoBee\Cygnus\Layout\Layout;
use SudoBee\Cygnus\Layout\Layouts\TopSideLayout;
use SudoBee\Cygnus\Page\Resolvers\LayoutResolver;
use SudoBee\Cygnus\Page\Resolvers\NavigationResolver;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller;
use Inertia\Response;
use SudoBee\Cygnus\Responses\StructuredPageResponse;

abstract class Page extends Controller
{
	use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
	use HasRegisterRoutes;
	use HasResolveHelpers;

	abstract public function title(): string;

	abstract public function route(): string;

	/**
	 * @return Component[]
	 */
	abstract public function nodes(): array;

	public function routeName(): ?string
	{
		return null;
	}

	/**
	 * @return string[]
	 */
	public function operations(): array
	{
		return [];
	}

	/**
	 * @return Component[]
	 */
	public function actions(): array
	{
		return [];
	}

	public function layout(): Layout
	{
		/**
		 * @var Layout|LayoutResolver $layout
		 */
		$layout = app(LayoutResolver::class);

		if ($layout instanceof LayoutResolver) {
			return TopSideLayout::make();
		}

		return $layout;
	}

	/**
	 * @return array{route: string, title: string, activeMatch: string}[]
	 */
	public function navigation(): array
	{
		$navigation = app(NavigationResolver::class);

		return ExportBuilder::exportArray($navigation->getNavigationItems());
	}

	protected function getPageTitle(): string
	{
		return $this->title();
	}

	/**
	 * @return array<int, array{
	 *     title: string,
	 *     count: int|null,
	 *     icon: string|null,
	 *     link: string,
	 *     active: bool
	 * }>
	 */
	protected function getTabs(): array
	{
		return [];
	}

	protected function getTabsDesign(): ?string
	{
		return null;
	}

	public function handleRequest(): Response
	{
		return StructuredPageResponse::make()
			->setTitle($this->getPageTitle())
			->setLayout($this->layout())
			->setTabs($this->getTabs())
			->setTabsDesign($this->getTabsDesign())
			->setNodes($this->nodes())
			->export();
	}

	public function registerRoutes(): void
	{
		foreach ($this->operations() as $operationClass) {
			/** @var Operation $operation */
			$operation = new $operationClass();

			$operation::register();
		}

		$routeName = $this->routeName();
		$route = RouteUtility::get(
			$this->route(),
			fn() => $this->handleRequest()
		);
		if ($routeName !== null) {
			$route->name($routeName);
		}
	}
}
