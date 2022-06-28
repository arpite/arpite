<?php

namespace Arpite\Arpite\Tests\Unit\Component\Components\Wizard;

use Arpite\Arpite\Component\Components\Wizard\WizardContent;
use Arpite\Arpite\Tests\Constants;
use Arpite\Arpite\Tests\TestCase;

class WizardContentTest extends TestCase
{
	public function test_initial_state(): void
	{
		$testWizard = WizardContent::make();

		$this->assertEquals(Constants::wizardContent(), $testWizard->export());
	}
}
