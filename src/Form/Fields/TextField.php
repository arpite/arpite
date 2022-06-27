<?php

namespace SudoBee\Cygnus\Form\Fields;

use SudoBee\Cygnus\Core\Utilities\ExportBuilder;
use Illuminate\Validation\Rules\Password;

/**
 * @extends Field<string>
 */
class TextField extends Field
{
	private string $type = "text";

	private function __construct(string $label, ?string $name = null)
	{
		parent::__construct($label, $name);

		$this->setDefaultValue("");

		$this->addValidationRule("string");

		$this->addValidationRule("max:255");
	}

	public static function make(string $label, ?string $name = null): self
	{
		return new self($label, $name);
	}

	/**
	 * @param string $type
	 * @return static
	 */
	public function setType(string $type)
	{
		$this->type = $type;

		return $this;
	}

	/**
	 * @return static
	 */
	public function presetEmail()
	{
		return $this->setType("email")->addValidationRule("email:rfc,dns");
	}

	/**
	 * @return static
	 */
	public function presetPassword()
	{
		return $this->setType("password")->addValidationRule(
			Password::default()
		);
	}

	/**
	 * @return mixed[]
	 */
	public function export(): array
	{
		return ExportBuilder::make($this)
			->mergeProperties($this->fieldExport())
			->addProperty("type", $this->type)
			->export();
	}
}
