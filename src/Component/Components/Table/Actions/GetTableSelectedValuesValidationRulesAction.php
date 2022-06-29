<?php

namespace Arpite\Component\Components\Table\Actions;

class GetTableSelectedValuesValidationRulesAction
{
	/**
	 * @param string $model
	 * @return array<string, mixed>
	 */
	public function execute(string $model): array
	{
		return [
			"selectedValues" => ["required", "array"],
			"selectedValues.*" => [
				"required",
				"string",
				"exists:" . $model . ",id",
			],
		];
	}
}
