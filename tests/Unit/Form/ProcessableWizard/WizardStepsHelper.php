<?php

namespace Arpite\Arpite\Tests\Unit\Form\ProcessableWizard;

use Arpite\Arpite\Component\Components\Wizard\Partials\WizardStep;
use Arpite\Arpite\Tests\Unit\Form\Fields\TestField;

class WizardStepsHelper
{
	public static function stepFirst(): object
	{
		return WizardStep::make()
			->setTitle("First step title")
			->setGetStepNodes(
				fn(object $validated) => [new TestField("First")]
			);
	}

	public static function stepSecond(): object
	{
		return WizardStep::make()
			->setTitle("Second step title")
			->setGetStepNodes(
				fn(object $validated) => [
					new TestField("Second1"),
					new TestField("Second2"),
				]
			);
	}

	public static function stepThird(): object
	{
		return WizardStep::make()
			->setTitle("Third step title")
			->setGetStepNodes(
				fn(object $validated) => [new TestField("Third")]
			);
	}
}
