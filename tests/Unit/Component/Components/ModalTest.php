<?php

namespace Arpite\Arpite\Tests\Unit\Component\Components;

use Arpite\Arpite\Component\Components\Modal\Modal;
use Arpite\Arpite\Form\Form;
use Exception;
use Arpite\Arpite\Tests\Constants;
use Arpite\Arpite\Tests\TestCase;
use Arpite\Arpite\Tests\Unit\Form\Operation\TestOperation;

const MODAL_COMPONENT_EXPORT = [
	"nodeType" => "Modal",
	"title" => null,
	"description" => null,
	"form" => null,
	"nodes" => [],
	"design" => "SIDE",
];

class ModalTest extends TestCase
{
	public function test_initial_state(): void
	{
		$testModal = Modal::make();

		$this->assertEquals(MODAL_COMPONENT_EXPORT, $testModal->export());
	}

	public function test_set_form(): void
	{
		$testModal = Modal::make()->setForm(Form::make(new TestOperation()));

		$this->assertEquals(
			array_merge(MODAL_COMPONENT_EXPORT, [
				"form" => Constants::form(),
			]),
			$testModal->export()
		);
	}

	public function test_set_design(): void
	{
		$testModal = Modal::make();
		$this->assertEquals(
			array_merge(MODAL_COMPONENT_EXPORT, [
				"design" => "SIDE",
			]),
			$testModal->export()
		);

		$testModal->asPageDesign();
		$this->assertEquals(
			array_merge(MODAL_COMPONENT_EXPORT, [
				"design" => "PAGE",
			]),
			$testModal->export()
		);

		$testModal->asSideDesign();
		$this->assertEquals(
			array_merge(MODAL_COMPONENT_EXPORT, [
				"design" => "SIDE",
			]),
			$testModal->export()
		);
	}

	/**
	 * @throws Exception
	 */
	public function test_should_throw_exception_when_form_and_modal_title_are_set(): void
	{
		$testModal = Modal::make()->setForm(Form::make(new TestOperation()));
		$testModal->export();

		$this->expectExceptionMessage(
			"Title and description is not allowed when using form in modal. Set title and description on form instead."
		);
		$testModal->setTitle("Modal title here")->export();
	}

	/**
	 * @throws Exception
	 */
	public function test_should_throw_exception_when_form_is_passed_with_set_nodes(): void
	{
		$testModal = Modal::make()->setNodes([Form::make(new TestOperation())]);

		$this->expectExceptionMessage(
			'Do not pass Form to "setNodes" method, instead use "setForm".'
		);
		$testModal->export();
	}

	/**
	 * @throws Exception
	 */
	public function test_should_throw_exception_when_form_and_modal_description_are_set(): void
	{
		$testModal = Modal::make()->setForm(Form::make(new TestOperation()));
		$testModal->export();

		$this->expectExceptionMessage(
			"Title and description is not allowed when using form in modal. Set title and description on form instead."
		);
		$testModal->setDescription("Modal description here")->export();
	}
}
