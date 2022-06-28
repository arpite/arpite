<?php

namespace Arpite\Arpite\Form\Fields;

use Arpite\Arpite\Core\Utilities\ExportBuilder;
use Arpite\Arpite\Form\Fields\Enums\ValidationRule;
use Domain\Country\Models\Country;
use Illuminate\Validation\Rule;

/**
 * @extends Field<mixed>
 */
class SelectField extends Field
{
	/** @var array{label: string, value: mixed, image?: string}[] $options */
	private array $options = [];

	const PRESET_COUNTRY_LIST = ["LT", "LV", "EE"];

	private function __construct(string $label, ?string $name = null)
	{
		parent::__construct($label, $name);

		$this->setDefaultValue(null);

		$this->addValidationRule(Rule::in([]));
	}

	public static function make(string $label, ?string $name = null): self
	{
		return new self($label, $name);
	}

	/**
	 * @param array<int, array{label: string, value: mixed, image?: string}> $options
	 * @return $this
	 */
	public function setOptions(array $options): self
	{
		$this->options = $options;

		$this->removeValidationRule(ValidationRule::RULE_IN);
		$this->addValidationRule(
			Rule::in(collect($this->options)->pluck("value"))
		);

		return $this;
	}

	public function presetCountries(): self
	{
		return $this->setDefaultValue(
			/** @phpstan-ignore-next-line */
			Country::whereCode("LT")->first()->id
		)->setOptions(
			Country::whereIn("code", SelectField::PRESET_COUNTRY_LIST)
				->orderBy("name->" . app()->getLocale())
				->get()
				->map(
					fn(Country $country) => [
						"value" => $country->id,
						"label" => $country->getTranslation("name"),
						"image" => $country->flag(),
					]
				)
				->all()
		);
	}

	/**
	 * @return array<string, mixed>
	 */
	public function export(): array
	{
		return ExportBuilder::make($this)
			->mergeProperties($this->fieldExport())
			->addProperty("options", $this->options)
			->export();
	}
}
