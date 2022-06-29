<?php

namespace Arpite\Core\Traits;

use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

trait HasResolveHelpers
{
	/**
	 * @param class-string<Model>|null $class
	 * @param string|null $name
	 * @param Builder<Model>|Relation<Model>|null $query
	 * @param string $modelRouteKeyName
	 * @return Model|mixed
	 */
	public function resolve(
		?string $class,
		?string $name = null,
		Builder|Relation|null $query = null,
		string $modelRouteKeyName = "id"
	) {
		/** @phpstan-ignore-next-line */
		$resolvedName = $name ?? Str::camel(class_basename($class));

		$value =
			request()->route($resolvedName) === null
				? /** @phpstan-ignore-next-line */
					$this->parameters[$resolvedName] ?? null
				: request()->route($resolvedName);

		if ($value === null) {
			abort(404, "Could not resolve \"$resolvedName\".");
		}

		if ($class === null) {
			return $value;
		}

		$query = $query ?? $class::query();

		/** @phpstan-ignore-next-line */
		return $query->where($modelRouteKeyName, $value)->firstOrFail();
	}

	/**
	 * @return string
	 * @throws Exception
	 */
	public function resolveRoute(): string
	{
		/** @phpstan-ignore-next-line */
		$route = $this->route();

		preg_match_all(
			"/{+(.*?)}/",
			/** @phpstan-ignore-next-line */
			$route,
			$parts,
			PREG_PATTERN_ORDER
		);

		$parameters = [];

		foreach ($parts[1] as $part) {
			$parameters[$part] = $this->resolve(null, $part);
		}

		foreach ($parameters as $key => $value) {
			/** @phpstan-ignore-next-line */
			$route = (string) Str::of($route)->replace(
				"{" . $key . "}",
				$value
			);
		}

		return $route;
	}
}
