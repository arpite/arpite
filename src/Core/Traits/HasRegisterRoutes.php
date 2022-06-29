<?php

namespace Arpite\Core\Traits;

trait HasRegisterRoutes
{
	public static function register(): void
	{
		$className = static::class;

		$instance = new $className();

		$instance->registerRoutes();
	}
}
