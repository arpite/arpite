<?php

namespace Arpite\Arpite\Tests\Unit\Component\Components;

use Arpite\Arpite\Component\Components\AddressDisplay;
use Domain\Carrier\Carriers\OmnivaCarrier;
use Domain\Carrier\Models\Carrier;
use Domain\Carrier\Models\Location;
use Domain\Country\Models\Country;
use Domain\Shipment\Enums\AddressType;
use Domain\Shipment\Models\Address;
use Domain\Team\Models\Team;
use Arpite\Arpite\Tests\Constants;
use Arpite\Arpite\Tests\TestCase;

class AddressDisplayTest extends TestCase
{
	private function createBaseAddress(array $parameters = [])
	{
		return Address::create(
			array_merge($parameters, [
				"type" => AddressType::EXTERNAL_INTEGRATION,
				"full_name" => "Tom Rotenson",
				"team_id" => Team::factory()->create()->id,
				"country_id" => Country::whereCode("LT")->first()->id,
			])
		);
	}

	private function createBaseAddressWithLocation(array $parameters = [])
	{
		return $this->createBaseAddress(
			array_merge($parameters, [
				"location_id" => Location::create([
					"title" => "Maxima XXX, Street 5641 USA",
					"reference_id" => "984984",
					"latitude" => "23.654654",
					"longitude" => "54.654654",
					"active" => true,
					"country_id" => Country::whereCode("LT")->first()->id,
					"carrier_id" => Carrier::whereHandler(
						OmnivaCarrier::class
					)->first()->id,
				])->id,
			])
		);
	}

	public function test_init(): void
	{
		$testAddressDisplay = AddressDisplay::make(
			$this->createBaseAddress([
				"phone_number" => "+37068640475",
			])
		);

		$this->assertEquals(
			Constants::addressDisplay([
				"lines" => ["Tom Rotenson", "Lithuania"],
			]),
			$testAddressDisplay->export()
		);
	}

	public function test_with_postal_code_and_without_city(): void
	{
		$addressDisplay = AddressDisplay::make(
			$this->createBaseAddress([
				"second_address" => "Address second line",
				"first_address" => "Address first line",
				"postal_code" => "55684",
			])
		);
		$this->assertEquals(
			Constants::addressDisplay([
				"lines" => [
					"Tom Rotenson",
					"Address first line",
					"Address second line",
					"55684",
					"Lithuania",
				],
			]),
			$addressDisplay->export()
		);
	}

	public function test_with_city_and_without_postal_code(): void
	{
		$addressDisplay = AddressDisplay::make(
			$this->createBaseAddress([
				"first_address" => "Address first line",
				"city" => "Moon city",
			])
		);
		$this->assertEquals(
			Constants::addressDisplay([
				"lines" => [
					"Tom Rotenson",
					"Address first line",
					"Moon city",
					"Lithuania",
				],
			]),
			$addressDisplay->export()
		);
	}

	public function test_with_city_and_postal_code(): void
	{
		$addressDisplay = AddressDisplay::make(
			$this->createBaseAddress([
				"first_address" => "Address first line",
				"city" => "Moon city",
				"postal_code" => "55684",
			])
		);
		$this->assertEquals(
			Constants::addressDisplay([
				"lines" => [
					"Tom Rotenson",
					"Address first line",
					"Moon city, 55684",
					"Lithuania",
				],
			]),
			$addressDisplay->export()
		);
	}

	public function test_with_location(): void
	{
		$addressDisplay = AddressDisplay::make(
			$this->createBaseAddressWithLocation([
				"phone_number" => "+37068640475",
				"second_address" => "Address second line",
				"first_address" => "Address first line",
				"postal_code" => "55684",
			])
		);
		$this->assertEquals(
			Constants::addressDisplay([
				"lines" => ["Tom Rotenson", "+370 686 40475"],
			]),
			$addressDisplay->export()
		);
	}

	public function test_as_location_display(): void
	{
		$addressDisplay = AddressDisplay::make(
			$this->createBaseAddressWithLocation()
		)->showLocation();

		$this->assertEquals(
			Constants::addressDisplay([
				"lines" => ["Maxima XXX", "Street 5641 USA"],
			]),
			$addressDisplay->export()
		);
	}

	public function test_with_location_without_phone_number(): void
	{
		$addressDisplay = AddressDisplay::make(
			$this->createBaseAddressWithLocation([
				"second_address" => "Address second line",
				"first_address" => "Address first line",
				"postal_code" => "55684",
			])
		);
		$this->assertEquals(
			Constants::addressDisplay([
				"lines" => ["Tom Rotenson"],
			]),
			$addressDisplay->export()
		);
	}
}
