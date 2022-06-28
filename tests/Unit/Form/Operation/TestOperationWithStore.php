<?php

namespace Arpite\Arpite\Tests\Unit\Form\Operation;

use Arpite\Arpite\Form\Operation;
use Arpite\Arpite\Form\Traits\HasStore;

class TestOperationWithStore extends Operation
{
	use HasStore;

	public function route(): string
	{
		return "/test/test-operation";
	}

	/**
	 * @param object $validated
	 * @return mixed
	 */
	public function handle(object $validated)
	{
		return [];
	}
}
