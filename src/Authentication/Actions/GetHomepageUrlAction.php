<?php

namespace Arpite\Authentication\Actions;

use Arpite\Authentication\Exceptions\HomepageNotFoundException;

class GetHomepageUrlAction
{
	/**
	 * @throws HomepageNotFoundException
	 */
	public function execute(): string
	{
		$routeServiceProviderClass = "App\Providers\RouteServiceProvider";

		if (
			class_exists($routeServiceProviderClass) &&
			/** @phpstan-ignore-next-line  */
			method_exists($routeServiceProviderClass, "getHomepage")
		) {
			return $routeServiceProviderClass::getHomepage();
		}

		if (defined($routeServiceProviderClass . "::HOME")) {
			return $routeServiceProviderClass::HOME;
		}

		throw new HomepageNotFoundException();
	}
}
