<?php

use Arpite\Tests\Unit\Form\ProcessableForm\TestProcessableForm;

beforeEach(function () {
	$this->withUser();
});

it(
	"should flash resetFormIdentifier in session when resetAfterSubmit is true",
	function () {
		request()->merge(["_formIdentifier" => "e8r7g4e8r"]);

		$processableForm = new class extends TestProcessableForm {
			protected bool $resetAfterSubmit = true;
		};
		expect(session()->get("resetFormIdentifier"))->toBe(null);

		$processableForm->handleRequest(request());
		expect(session()->get("resetFormIdentifier"))->toBe("e8r7g4e8r");
	}
);

it(
	"should not flash resetFormIdentifier in session when resetAfterSubmit is false",
	function () {
		request()->merge(["_formIdentifier" => "e8r7g4e8r"]);

		$processableForm = new class extends TestProcessableForm {
			protected bool $resetAfterSubmit = false;
		};
		expect(session()->get("resetFormIdentifier"))->toBe(null);

		$processableForm->handleRequest(request());
		expect(session()->get("resetFormIdentifier"))->toBe(null);
	}
);
