<?php

namespace Arpite\Tests;

use Illuminate\Contracts\Console\Kernel;
use Illuminate\Foundation\Application;

trait CreatesApplication
{
	/**
	 * Creates the application.
	 *
	 * @return Application
	 */
	public function createApplication(): Application
	{
		$app = require __DIR__ . "/../bootstrap/app.php";

		$app->make(Kernel::class)->bootstrap();

		$app->setLocale("en");

		return $app;
	}
}
