<?php

namespace SudoBee\Cygnus\Tests\Unit\Component\Components\Wizard;

use SudoBee\Cygnus\Component\Components\Wizard\WizardContent;
use SudoBee\Cygnus\Tests\Constants;
use SudoBee\Cygnus\Tests\TestCase;

class WizardContentTest extends TestCase
{
	public function test_initial_state(): void
	{
		$testWizard = WizardContent::make();

		$this->assertEquals(Constants::wizardContent(), $testWizard->export());
	}
}
