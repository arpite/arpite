<?php

namespace Arpite\Tests\Unit\Component\Components\Wizard;

use Arpite\Component\Components\Wizard\WizardContent;
use Arpite\Tests\Constants;
use Arpite\Tests\TestCase;

class WizardContentTest extends TestCase
{
	public function test_initial_state(): void
	{
		$testWizard = WizardContent::make();

		$this->assertEquals(Constants::wizardContent(), $testWizard->export());
	}
}
