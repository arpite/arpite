<?php

namespace Arpite\Tests\Unit\Form\Fields;

use Arpite\Form\Fields\SelectField;
use Database\Seeders\DatabaseSeeder;
use Domain\Country\Models\Country;
use Illuminate\Validation\Rule;
use Arpite\Tests\TestCase;

class SelectFieldTest extends TestCase
{
	public function test_initial_state(): void
	{
		$field = SelectField::make("First");

		$this->assertEquals(
			["first" => ["required", Rule::in([])]],
			$field->getValidationRules((object) [])
		);
		$this->assertEquals(
			[
				"nodeType" => "SelectField",
				"name" => "first",
				"label" => "First",
				"defaultValue" => "",
				"required" => true,
				"disabled" => false,
				"placeholder" => null,
				"explanation" => null,
				"options" => [],
				"dependees" => [],
			],
			$field->export()
		);
	}

	public function test_set_options(): void
	{
		$field = SelectField::make("First");

		$this->assertEquals(
			["first" => ["required", Rule::in([])]],
			$field->getValidationRules((object) [])
		);
		$field->setOptions([
			[
				"label" => "Omniva",
				"value" => "omniva",
				"image" => "/images/carriers/OmnivaCarrier.png",
			],
			[
				"label" => "DPD",
				"value" => "dpd",
				"image" => "/images/carriers/DPDCarrier.png",
			],
			[
				"label" => "LP Express",
				"value" => "lp-express",
				"image" => "/images/carriers/LPCarrier.png",
			],
		]);

		$this->assertEquals(
			[
				"first" => [
					"required",
					Rule::in(["omniva", "dpd", "lp-express"]),
				],
			],
			$field->getValidationRules((object) [])
		);
		$this->assertEquals(
			[
				"nodeType" => "SelectField",
				"name" => "first",
				"label" => "First",
				"defaultValue" => "",
				"required" => true,
				"disabled" => false,
				"placeholder" => null,
				"explanation" => null,
				"options" => [
					[
						"label" => "Omniva",
						"value" => "omniva",
						"image" => "/images/carriers/OmnivaCarrier.png",
					],
					[
						"label" => "DPD",
						"value" => "dpd",
						"image" => "/images/carriers/DPDCarrier.png",
					],
					[
						"label" => "LP Express",
						"value" => "lp-express",
						"image" => "/images/carriers/LPCarrier.png",
					],
				],
				"dependees" => [],
			],
			$field->export()
		);
	}

	public function test_preset_countries(): void
	{
		$this->seed(DatabaseSeeder::class);

		$field = SelectField::make("Country")->presetCountries();

		$this->assertEquals(
			[
				"nodeType" => "SelectField",
				"name" => "country",
				"label" => "Country",
				"defaultValue" => Country::whereCode("LT")->first()->id,
				"required" => true,
				"disabled" => false,
				"placeholder" => null,
				"explanation" => null,
				"options" => Country::whereIn(
					"code",
					SelectField::PRESET_COUNTRY_LIST
				)
					->orderBy("name->" . app()->getLocale())
					->get()
					->map(
						fn(Country $country) => [
							"image" => $country->flag(32),
							"label" => $country->getTranslation("name"),
							"value" => $country->id,
						]
					)
					->all(),
				"dependees" => [],
			],
			$field->export()
		);
	}
}
