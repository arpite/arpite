<?php

namespace Arpite\Tests\Unit\Form\ProcessableForm;

use Arpite\Form\ProcessableForm;

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
