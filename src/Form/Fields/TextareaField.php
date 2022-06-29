<?php

namespace Arpite\Form\Fields;

use Arpite\Core\Utilities\ExportBuilder;

/**
 * @extends Field<string>
 */
class TextareaField extends Field
{
	private int $height = 120;

	private bool $resizable = true;

	private function __construct(string $label, ?string $name = null)
	{
		parent::__construct($label, $name);

		$this->setDefaultValue("");

		$this->addValidationRule("string");

		$this->addValidationRule("max:3000");
	}

	public static function make(string $label, ?string $name = null): self
	{
		return new self($label, $name);
	}

	/**
	 * @param int $height
	 * @return static
	 */
	public function setHeight(int $height)
	{
		$this->height = $height;

		return $this;
	}

	/**
	 * @param bool $resizable
	 * @return static
	 */
	public function setResizable(bool $resizable)
	{
		$this->resizable = $resizable;

		return $this;
	}

	/**
	 * @return array<string, mixed>
	 */
	public function export(): array
	{
		return ExportBuilder::make($this)
			->mergeProperties($this->fieldExport())
			->addProperty("height", $this->height)
			->addProperty("resizable", $this->resizable)
			->export();
	}
}
