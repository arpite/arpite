<?php

namespace SudoBee\Cygnus\Tests\Unit\Form\ProcessableWizard;

use SudoBee\Cygnus\Component\Components\Wizard\Partials\WizardStep;
use SudoBee\Cygnus\Form\ProcessableWizard;
use SudoBee\Cygnus\Tests\Unit\Form\Fields\TestField;

class TestProcessableWizard extends ProcessableWizard
{
	public function route(): string
	{
		return "/test/test-wizard";
	}

	/**
	 * @param object $validated
	 * @return mixed
	 */
	public function handle(object $validated)
	{
		return redirect("/test/somewhere");
	}

	/**
	 * @return WizardStep[]
	 */
	public function steps(object $validated): array
	{
		return [
			$this->getFirstStep(),
			$this->getSecondStep(),
			$this->getThirdStep(),
		];
	}

	private function getFirstStep(): WizardStep
	{
		$getNodes = fn(object $validated) => [new TestField("First")];

		return WizardStep::make()
			->setTitle("First step title")
			->setGetStepNodes($getNodes);
	}

	private function getSecondStep(): WizardStep
	{
		$getNodes = fn(object $validated) => [
			new TestField("Second1"),
			new TestField("Second2"),
		];

		return WizardStep::make()
			->setTitle("Second step title")
			->setGetStepNodes($getNodes);
	}

	private function getThirdStep(): WizardStep
	{
		$getNodes = fn(object $validated) => [new TestField("Third")];

		return WizardStep::make()
			->setTitle("Third step title")
			->setGetStepNodes($getNodes);
	}
}
