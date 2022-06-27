<?php

namespace SudoBee\Cygnus\Tests\Unit\Component\Components\Wizard;

use SudoBee\Cygnus\Component\Components\Wizard\Partials\WizardStep;
use SudoBee\Cygnus\Tests\Constants;
use SudoBee\Cygnus\Tests\TestCase;

class WizardStepTest extends TestCase
{
	public function test_initial_state(): void
	{
		$testWizardStep = WizardStep::make();

		$this->assertEquals(Constants::wizardStep(), $testWizardStep->export());
	}

	public function test_set_index(): void
	{
		$testWizardStep = WizardStep::make()->setIndex(2);

		$this->assertEquals(
			Constants::wizardStep([
				"index" => 2,
			]),
			$testWizardStep->export()
		);
	}

	public function test_set_active(): void
	{
		$testWizardStep = WizardStep::make();
		$this->assertEquals(
			Constants::wizardStep([
				"active" => false,
			]),
			$testWizardStep->export()
		);

		$testWizardStep->setActive(true);
		$this->assertEquals(
			Constants::wizardStep([
				"active" => true,
			]),
			$testWizardStep->export()
		);

		$testWizardStep->setActive(false);
		$this->assertEquals(
			Constants::wizardStep([
				"active" => false,
			]),
			$testWizardStep->export()
		);
	}
}
