<?php

namespace SudoBee\Cygnus\Tests\Unit\Component\Components\Wizard;

use SudoBee\Cygnus\Component\Components\Wizard\Partials\WizardStep;
use SudoBee\Cygnus\Component\Components\Wizard\WizardHeader;
use SudoBee\Cygnus\Tests\Constants;
use SudoBee\Cygnus\Tests\TestCase;

class WizardHeaderTest extends TestCase
{
	public function test_initial_state(): void
	{
		$testWizard = WizardHeader::make();

		$this->assertEquals(Constants::wizardHeader(), $testWizard->export());
	}

	public function test_set_steps(): void
	{
		$testWizard = WizardHeader::make()->setSteps([
			WizardStep::make(),
			WizardStep::make(),
		]);

		$this->assertEquals(
			Constants::wizardHeader([
				"steps" => [
					Constants::wizardStep([
						"index" => 0,
						"active" => true,
						"highlighted" => true,
					]),
					Constants::wizardStep([
						"index" => 1,
						"active" => false,
						"highlighted" => false,
					]),
				],
			]),
			$testWizard->export()
		);
	}

	public function test_set_active_step(): void
	{
		$testWizard = WizardHeader::make()
			->setSteps([
				WizardStep::make(),
				WizardStep::make(),
				WizardStep::make(),
				WizardStep::make(),
			])
			->setActiveIndex(2);

		$this->assertEquals(
			Constants::wizardHeader([
				"steps" => [
					Constants::wizardStep([
						"index" => 0,
						"active" => false,
						"highlighted" => true,
					]),
					Constants::wizardStep([
						"index" => 1,
						"active" => false,
						"highlighted" => true,
					]),
					Constants::wizardStep([
						"index" => 2,
						"active" => true,
						"highlighted" => true,
					]),
					Constants::wizardStep([
						"index" => 3,
						"active" => false,
					]),
				],
				"activeIndex" => 2,
			]),
			$testWizard->export()
		);
	}
}
