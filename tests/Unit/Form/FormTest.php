<?php

namespace Arpite\Tests\Unit\Form;

use Arpite\Component\Components\Grid;
use Arpite\Component\Components\Panel;
use Arpite\Form\Form;
use Arpite\Form\Form\FormButton;
use Arpite\Tests\Constants;
use Arpite\Tests\TestCase;
use Arpite\Tests\Unit\Component\TestComponent;
use Arpite\Tests\Unit\Form\Fields\TestField;
use Arpite\Tests\Unit\Form\Operation\TestOperation;

class FormTest extends TestCase
{
	public function test_initial_state(): void
	{
		$form = Form::make(new TestOperation());

		$this->assertEquals(Constants::form(), $form->export());
	}

	public function test_set_values(): void
	{
		$form = Form::make(new TestOperation());

		$form->setValues([
			"foo" => "foo value here",
			"bar" => "bar value here",
		]);

		$this->assertEquals(
			Constants::form([
				"values" => [
					"foo" => "foo value here",
					"bar" => "bar value here",
				],
			]),
			$form->export()
		);
	}

	public function test_given_null_values_should_not_be_overwritten_with_field_default_value(): void
	{
		$form = Form::make(new TestOperation());

		$form->setNodes([
			new TestField("First"),
			new TestField("Second"),
			(new TestField("Third"))->setDefaultValue("Bob"),
			new TestField("Forth"),
			(new TestField("Fifth"))->setDefaultValue("Rom"),
		]);
		$this->assertEquals(
			[
				"first" => "",
				"second" => "",
				"third" => "Bob",
				"forth" => "",
				"fifth" => "Rom",
			],
			$form->export()["values"]
		);

		$form->setValues([
			"second" => null,
			"third" => null,
			"forth" => "Tippy",
			"fifth" => "",
		]);
		$this->assertEquals(
			[
				"first" => "",
				"second" => null,
				"third" => null,
				"forth" => "Tippy",
				"fifth" => "",
			],
			$form->export()["values"]
		);
	}

	public function test_set_fields(): void
	{
		$form = Form::make(new TestOperation());

		$form->setNodes([new TestField("First")]);

		$this->assertEquals(
			Constants::form([
				"values" => [
					"first" => "",
				],
				"nodes" => [Constants::field()],
			]),
			$form->export()
		);
	}

	public function test_set_left_buttons(): void
	{
		$form = Form::make(new TestOperation());

		$form->setLeftButtons([
			FormButton::make()->setTitle("Boop"),
			FormButton::make(),
		]);

		$this->assertEquals(
			Constants::form([
				"leftButtons" => [
					Constants::formButton(["title" => "Boop"]),
					Constants::formButton(),
				],
			]),
			$form->export()
		);
	}

	public function test_set_right_buttons(): void
	{
		$form = Form::make(new TestOperation());

		$form->setRightButtons([]);

		$this->assertEquals(
			Constants::form([
				"rightButtons" => [],
			]),
			$form->export()
		);
	}

	public function test_set_submit_button_text(): void
	{
		$form = Form::make(new TestOperation());
		$this->assertEquals(
			Constants::form([
				"rightButtons" => [
					Constants::formButton(["title" => "Submit"]),
				],
			]),
			$form->export()
		);

		$form->setSubmitButtonText("Go");
		$this->assertEquals(
			Constants::form([
				"rightButtons" => [Constants::formButton(["title" => "Go"])],
			]),
			$form->export()
		);
	}

	public function test_add_left_button_on_left(): void
	{
		$form = Form::make(new TestOperation());
		$form->setLeftButtons([FormButton::make()->setTitle("Submit")]);
		$this->assertEquals(
			Constants::form([
				"leftButtons" => [Constants::formButton(["title" => "Submit"])],
			]),
			$form->export()
		);

		$form->addLeftButtonOnLeft(FormButton::make());
		$this->assertEquals(
			Constants::form([
				"leftButtons" => [
					Constants::formButton(),
					Constants::formButton(["title" => "Submit"]),
				],
			]),
			$form->export()
		);
	}

	public function test_add_left_button_on_right(): void
	{
		$form = Form::make(new TestOperation());
		$form->setLeftButtons([FormButton::make()->setTitle("Submit")]);
		$this->assertEquals(
			Constants::form([
				"leftButtons" => [Constants::formButton(["title" => "Submit"])],
			]),
			$form->export()
		);

		$form->addLeftButtonOnRight(FormButton::make());
		$this->assertEquals(
			Constants::form([
				"leftButtons" => [
					Constants::formButton(["title" => "Submit"]),
					Constants::formButton(),
				],
			]),
			$form->export()
		);
	}

	public function test_add_right_button_on_left(): void
	{
		$form = Form::make(new TestOperation());
		$this->assertEquals(
			Constants::form([
				"rightButtons" => [
					Constants::formButton(["title" => "Submit"]),
				],
			]),
			$form->export()
		);

		$form->addRightButtonOnLeft(FormButton::make());
		$this->assertEquals(
			Constants::form([
				"rightButtons" => [
					Constants::formButton(),
					Constants::formButton(["title" => "Submit"]),
				],
			]),
			$form->export()
		);
	}

	public function test_add_right_button_on_right(): void
	{
		$form = Form::make(new TestOperation());
		$this->assertEquals(
			Constants::form([
				"rightButtons" => [
					Constants::formButton(["title" => "Submit"]),
				],
			]),
			$form->export()
		);

		$form->addRightButtonOnRight(FormButton::make());
		$this->assertEquals(
			Constants::form([
				"rightButtons" => [
					Constants::formButton(["title" => "Submit"]),
					Constants::formButton(),
				],
			]),
			$form->export()
		);
	}

	public function test_set_sticky_header(): void
	{
		$form = Form::make(new TestOperation());

		$form->setStickyHeader([new TestComponent(), new TestComponent()]);
		$this->assertEquals(
			Constants::form([
				"stickyHeader" => [
					Constants::testComponent(),
					Constants::testComponent(),
				],
			]),
			$form->export()
		);
	}

	// TEMP DISABLED
	//	public function test_with_panel_and_without_panel(): void
	//	{
	//		$form = Form::make(new TestOperation())->withPanel();
	//
	//		$this->assertEquals(
	//			[
	//				'nodeType' => 'Panel',
	//				'nodes' => [Constants::form()],
	//				'actions' => [],
	//				'title' => null,
	//				'description' => null,
	//			],
	//			$form->export()
	//		);
	//
	//		$form->withoutPanel();
	//
	//		$this->assertEquals(Constants::form(), $form->export());
	//	}

	public function test_get_validation_rules(): void
	{
		$form = Form::make(new TestOperation());

		$form->setNodes([
			new TestField("First"),
			new TestComponent(),
			(new TestField("Second"))->addValidationRule("string"),
			new TestField("Third"),
		]);

		$this->assertEquals(
			[
				"first" => ["required"],
				"second" => ["required", "string"],
				"third" => ["required"],
			],
			$form->getValidationRules((object) [])
		);
	}

	public function test_accepts_table_selected_values(): void
	{
		$form = Form::make(new TestOperation());

		$form->setNodes([
			new TestField("First"),
			(new TestField(
				"Selected Values Fake",
				"selectedValues"
			))->addValidationRule("min:4574"),
			new TestComponent(),
			(new TestField("Second"))->addValidationRule("max:125478"),
			new TestField("Third"),
		]);

		$this->assertEquals(
			[
				"first" => ["required"],
				"second" => ["required", "max:125478"],
				"third" => ["required"],
				"selectedValues" => ["required", "min:4574"],
			],
			$form->getValidationRules((object) [])
		);

		$form->acceptsTableSelectedValues("App\Modals\User");
		$this->assertEquals(
			[
				"first" => ["required"],
				"second" => ["required", "max:125478"],
				"third" => ["required"],
				"selectedValues" => ["required", "array"],
				"selectedValues.*" => [
					"required",
					"string",
					"exists:App\Modals\User,id",
				],
			],
			$form->getValidationRules((object) [])
		);
	}

	public function test_should_get_nested_fields_needed_properties(): void
	{
		$form = Form::make(new TestOperation());

		$form->setNodes([
			(new TestField("First"))->setDefaultValue("firstee"),
			Grid::make()
				->setColumns([1, 1, 1])
				->setNodes([
					(new TestField("Second"))->setDefaultValue("secondee"),
					(new TestField("Third"))
						->setDefaultValue("thirdee")
						->addValidationRule("string"),
					Panel::make()->setNodes([
						(new TestField("Fourth"))
							->setDefaultValue("fourthee")
							->addValidationRule("min:6"),
					]),
				]),
		]);

		$form->setValues([
			"third" => "overwritten third field value",
		]);

		$this->assertEquals(
			[
				"first" => ["required"],
				"second" => ["required"],
				"third" => ["required", "string"],
				"fourth" => ["required", "min:6"],
			],
			$form->getValidationRules((object) [])
		);

		$this->assertEquals(
			Constants::form([
				"values" => [
					"first" => "firstee",
					"second" => "secondee",
					"third" => "overwritten third field value",
					"fourth" => "fourthee",
				],
				"nodes" => [
					Constants::field([
						"defaultValue" => "firstee",
					]),
					[
						"nodeType" => "Grid",
						"columns" => ["d" => [1, 1, 1]],
						"nodes" => [
							Constants::field([
								"name" => "second",
								"label" => "Second",
								"defaultValue" => "secondee",
							]),
							Constants::field([
								"name" => "third",
								"label" => "Third",
								"defaultValue" => "thirdee",
							]),
							[
								"nodeType" => "Panel",
								"nodes" => [
									Constants::field([
										"name" => "fourth",
										"label" => "Fourth",
										"defaultValue" => "fourthee",
									]),
								],
								"actions" => [],
								"title" => null,
								"description" => null,
								"padding" => 6,
							],
						],
						"gap" => 4,
					],
				],
			]),
			$form->export()
		);
	}
}
