<?php

namespace SudoBee\Cygnus\Form\ProcessableWizard;

use SudoBee\Cygnus\Form\Form;
use SudoBee\Cygnus\Form\ProcessableWizard;

class ProcessableWizardForm
{
	private ProcessableWizard $processableWizard;

	/** @var array<string, mixed> $values */
	private array $values = [];

	private function __construct(ProcessableWizard $processableWizard)
	{
		$this->processableWizard = $processableWizard;
	}

	public static function make(ProcessableWizard $processableWizard): self
	{
		return new self($processableWizard);
	}

	/**
	 * @param array<string, mixed> $values
	 * @return $this
	 */
	public function setValues(array $values): self
	{
		$this->values = $values;

		return $this;
	}

	public function getForm(): Form
	{
		$form = $this->processableWizard->getForm(
			(object) array_merge($this->values, [
				"step" => 0,
				"submitAction" => "reload",
				"computedValues" => [],
			])
		);

		return $form->setValues(array_merge($this->values, $form->getValues()));
	}
}
