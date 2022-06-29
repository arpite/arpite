<?php

namespace Arpite\Tests\Unit\Form\Operation;

use Arpite\Form\Operation;

class TestOperation extends Operation
{
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
