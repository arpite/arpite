<?php

namespace SudoBee\Cygnus;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class CygnusServiceProvider extends PackageServiceProvider
{
	public function configurePackage(Package $package): void
	{
		$package->name("cygnus")->hasAssets();
	}
}
