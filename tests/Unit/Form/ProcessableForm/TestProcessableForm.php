<?php

namespace SudoBee\Cygnus\Tests\Unit\Form\ProcessableForm;

use SudoBee\Cygnus\Form\ProcessableForm;

class TestProcessableForm extends ProcessableForm
{
	public function route(): string
	{
		return "/test/test-form";
	}

	/**
	 * @param object $validated
	 * @return mixed
	 */
	public function handle(object $validated)
	{
		return redirect("/test/form-somewhere");
	}
}
