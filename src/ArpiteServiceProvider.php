<?php

namespace Arpite;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class ArpiteServiceProvider extends PackageServiceProvider
{
	public function configurePackage(Package $package): void
	{
		$package->name("arpite")->hasViews();
	}
}
