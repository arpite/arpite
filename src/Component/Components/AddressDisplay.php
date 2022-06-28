<?php

namespace Arpite\Arpite\Component\Components;

use Arpite\Arpite\Component\Component;
use Arpite\Arpite\Core\Utilities\ExportBuilder;
use Domain\Shipment\Models\Address;
use Domain\Shipment\Utilities\PhoneNumber;
use libphonenumber\PhoneNumberFormat;

class AddressDisplay extends Component
{
	private Address $address;

	private bool $displayLocation = false;

	private function __construct(Address $address)
	{
		$this->address = $address;
	}

	/**
	 * @return static
	 */
	public function showLocation()
	{
		$this->displayLocation = true;

		return $this;
	}

	public static function make(Address $address): self
	{
		return new self($address);
	}

	/**
	 * @return array<int, string>
	 */
	private function getDefaultLines(): array
	{
		$lines = [$this->address->full_name];

		$location = $this->address->location;
		if ($location === null) {
			$lines = array_merge($lines, [
				$this->address->first_address,
				$this->address->second_address,
				($this->address->city ?? "") .
				($this->address->city === null ||
				$this->address->postal_code === null
					? ""
					: ", ") .
				($this->address->postal_code ?? ""),
				$this->address->country->getTranslation("name"),
			]);
		} else {
			$lines = array_merge($lines, [
				$this->address->phone_number !== null
					? PhoneNumber::formatByCountry(
						$this->address->phone_number,
						PhoneNumberFormat::INTERNATIONAL,
						$this->address->country->code
					)
					: null,
				$this->address->email,
			]);
		}

		$lines = array_values(
			array_filter(
				$lines,
				fn($line) => $line !== null && trim($line) !== ""
			)
		);

		return $lines;
	}

	/**
	 * @return array<int, string>
	 */
	private function getLocationLines(): array
	{
		$location = $this->address->location;

		if ($location === null) {
			return [];
		}

		return array_map(
			fn(string $string) => trim($string),
			explode(",", $location->title)
		);
	}

	/**
	 * @return array<mixed>
	 */
	public function export(): array
	{
		return ExportBuilder::make($this)
			->addProperty(
				"lines",
				$this->displayLocation
					? $this->getLocationLines()
					: $this->getDefaultLines()
			)
			->export();
	}
}
