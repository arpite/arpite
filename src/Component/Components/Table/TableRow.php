<?php

namespace SudoBee\Cygnus\Component\Components\Table;

use SudoBee\Cygnus\Component\Component;
use SudoBee\Cygnus\Core\Utilities\ExportBuilder;

class TableRow extends Component
{
	private string $id;

	/**
	 * @var array<mixed>
	 */
	private array $values = [];

	private function __construct(string|int $id)
	{
		$this->id = strval($id);
	}

	public static function make(string|int $id): self
	{
		return new self($id);
	}

	/**
	 * @param array<mixed> $values
	 * @return $this
	 */
	public function setValues(array $values): self
	{
		$this->values = $values;

		return $this;
	}

	/**
	 * @param array<mixed> $values
	 * @return array<mixed>
	 */
	private function getExportedValues(array $values): array
	{
		return array_map(
			fn($value) => $value instanceof Component
				? $value->export()
				: $value,
			array_values($values)
		);
	}

	/**
	 * @return array<mixed>
	 */
	public function export(): array
	{
		$exportedValues = $this->getExportedValues($this->values);

		return ExportBuilder::make($this)
			->addProperty("id", $this->id)
			->addProperty("values", $exportedValues)
			->export();
	}
}
