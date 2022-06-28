<?php

namespace Arpite\Arpite\Core\Utilities;

use Arpite\Arpite\Core\Interfaces\Exportable;

class ExportBuilder
{
	private ?Exportable $exportable;

	/**
	 * @var array<string, mixed>
	 */
	private array $properties;

	private function __construct(?Exportable $exportable)
	{
		$this->exportable = $exportable;
		$this->properties = [];
	}

	public static function make(?Exportable $exportable = null): ExportBuilder
	{
		return new self($exportable);
	}

	/**
	 * @param Exportable[] $exportables
	 * @return array<int, mixed>
	 */
	public static function exportArray(array $exportables): array
	{
		return array_map(
			fn(Exportable $exportable) => $exportable->export(),
			$exportables
		);
	}

	/**
	 * @param string $property
	 * @param mixed $value
	 * @return $this
	 */
	public function addProperty(string $property, mixed $value): ExportBuilder
	{
		if ($value instanceof Exportable) {
			$this->properties[$property] = $value->export();
		} else {
			$this->properties[$property] = $value;
		}

		return $this;
	}

	/**
	 * @param bool $condition
	 * @param string $property
	 * @param mixed $value
	 * @return $this
	 */
	public function addPropertyIf(
		bool $condition,
		string $property,
		mixed $value
	): ExportBuilder {
		if ($condition) {
			$this->addProperty($property, $value);
		}

		return $this;
	}

	/**
	 * @param string $property
	 * @param Exportable[] $exportables
	 * @return $this
	 */
	public function addNodesProperty(
		string $property,
		array $exportables
	): ExportBuilder {
		$this->properties = array_merge($this->properties, [
			$property => $this->exportArray($exportables),
		]);

		return $this;
	}

	/**
	 * @param array<string, mixed> $properties
	 * @return ExportBuilder
	 */
	public function mergeProperties(array $properties): self
	{
		foreach ($properties as $name => $value) {
			$this->addProperty($name, $value);
		}

		return $this;
	}

	/**
	 * @return array<string, mixed>
	 */
	public function export(): array
	{
		if (isset($this->exportable)) {
			return array_merge(
				["nodeType" => class_basename($this->exportable)],
				$this->properties
			);
		}

		return $this->properties;
	}
}
