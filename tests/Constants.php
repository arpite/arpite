<?php

namespace Arpite\Tests;

use Arpite\Component\Components\Card\Enums\CardDesignEnum;

class Constants
{
	public static function form(array $data = []): array
	{
		return array_merge(
			[
				"nodeType" => "Form",
				"title" => null,
				"description" => null,
				"actions" => [],
				"leftButtons" => [],
				"rightButtons" => [
					Constants::formButton(["title" => "Submit"]),
				],
				"action" => "/test/test-operation",
				"values" => [],
				"stickyHeader" => [],
				"nodes" => [],
				"actionResponseType" => "REGULAR",
				"withPanel" => true,
			],
			$data
		);
	}

	public static function fileField(array $data = []): array
	{
		return Constants::field(
			array_merge(
				[
					"nodeType" => "FileField",
					"acceptedExtensions" => ["jpg", "jpeg", "png", "bmp"],
					"defaultValue" => [],
				],
				$data
			)
		);
	}

	public static function button(array $data = []): array
	{
		return array_merge(
			[
				"nodeType" => "Button",
				"title" => null,
				"link" => null,
				"icon" => null,
				"design" => "primary",
				"action" => null,
				"nodesAction" => null,
				"actionAlert" => null,
				"modal" => null,
				"type" => "button",
				"disabled" => false,
				"blank" => false,
				"color" => "primary",
				"fullWidth" => false,
			],
			$data
		);
	}

	public static function formButton(array $data = []): array
	{
		return array_merge(
			[
				"nodeType" => "FormButton",
				"title" => null,
				"design" => "primary",
				"color" => "primary",
				"withData" => [],
				"forceActionResponseType" => null,
				"withoutFrontendValidation" => false,
			],
			$data
		);
	}

	public static function dependee(array $data = []): array
	{
		return array_merge(
			[
				"nodes" => [],
				"value" => "",
				"fieldsDefaultValues" => [],
			],
			$data
		);
	}

	public static function card(array $data = []): array
	{
		return array_merge(
			[
				"nodeType" => "Card",
				"title" => null,
				"description" => null,
				"image" => null,
				"buttons" => [],
				"design" => CardDesignEnum::REGULAR,
			],
			$data
		);
	}

	public static function pricingPlan(array $data = []): array
	{
		return array_merge(
			[
				"nodeType" => "PricingPlan",
				"title" => null,
				"description" => null,
				"buttons" => [],
				"yearlyInterval" => self::pricingPlanInterval(),
				"monthlyInterval" => self::pricingPlanInterval(),
				"features" => [],
			],
			$data
		);
	}

	public static function pricingPlans(array $data = []): array
	{
		return array_merge(
			[
				"nodeType" => "PricingPlans",
				"title" => null,
				"description" => null,
				"plans" => [],
			],
			$data
		);
	}

	public static function pricingPlanInterval(array $data = []): array
	{
		return array_merge(
			[
				"nodeType" => "PricingPlanInterval",
				"buttons" => [],
				"price" => 0,
				"active" => false,
			],
			$data
		);
	}

	public static function currentPricingPlans(array $data = []): array
	{
		return array_merge(
			[
				"nodeType" => "CurrentPricingPlans",
				"title" => null,
				"description" => null,
				"plans" => [],
			],
			$data
		);
	}

	public static function currentPricingPlan(array $data = []): array
	{
		return array_merge(
			[
				"nodeType" => "CurrentPricingPlan",
				"title" => null,
				"description" => null,
				"buttons" => [],
			],
			$data
		);
	}

	public static function modal(array $data = []): array
	{
		return array_merge(
			[
				"nodeType" => "Modal",
				"title" => null,
				"description" => null,
				"form" => null,
				"nodes" => [],
				"design" => "SIDE",
			],
			$data
		);
	}

	public static function testComponent(array $data = []): array
	{
		return array_merge(["nodeType" => "TestComponent"], $data);
	}

	public static function field(array $data = []): array
	{
		return array_merge(
			[
				"nodeType" => "TestField",
				"name" => "first",
				"label" => "First",
				"defaultValue" => null,
				"required" => true,
				"disabled" => false,
				"placeholder" => null,
				"explanation" => null,
				"dependees" => [],
			],
			$data
		);
	}

	public static function toggleField(array $data = []): array
	{
		return array_merge(
			[
				"nodeType" => "ToggleField",
				"label" => "Active",
				"name" => "active",
				"defaultValue" => false,
				"required" => true,
				"disabled" => false,
				"placeholder" => null,
				"explanation" => null,
				"description" => null,
				"dependees" => [],
			],
			$data
		);
	}

	public static function radiosField(array $data = []): array
	{
		return array_merge(
			[
				"nodeType" => "RadiosField",
				"name" => "favorite_fruit",
				"label" => "Favorite fruit",
				"defaultValue" => null,
				"required" => true,
				"disabled" => false,
				"placeholder" => null,
				"explanation" => null,
				"radios" => [],
				"dependees" => [],
			],
			$data
		);
	}

	public static function radiosButton(array $data = []): array
	{
		return array_merge(
			[
				"nodeType" => "RadioButton",
				"title" => null,
				"description" => null,
				"value" => "Apple",
			],
			$data
		);
	}

	public static function wizardHeader(array $data = []): array
	{
		return array_merge(
			[
				"nodeType" => "WizardHeader",
				"activeIndex" => 0,
				"design" => "STEPS",
				"steps" => [],
			],
			$data
		);
	}

	public static function wizardStep(array $data = []): array
	{
		return array_merge(
			[
				"index" => 0,
				"active" => false,
				"highlighted" => false,
				"title" => null,
			],
			$data
		);
	}

	public static function wizardContent(array $data = []): array
	{
		return array_merge(
			[
				"nodeType" => "WizardContent",
				"nodes" => [],
			],
			$data
		);
	}

	public static function operationResponseJson(array $data = []): array
	{
		return array_merge(
			[
				"success" => true,
				"data" => [],
				"errors" => null,
				"notification" => null,
			],
			$data
		);
	}

	public static function addressDisplay(array $data = []): array
	{
		return array_merge(
			[
				"nodeType" => "AddressDisplay",
				"lines" => [],
			],
			$data
		);
	}
}
