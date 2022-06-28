<?php

namespace Arpite\Arpite\ResourceFieldConfiguration;

use Illuminate\Support\Collection;
use Arpite\Arpite\Resource\Enums\ResourcePageType;

class ResourceFieldConfiguration
{
	/** @var Collection<string, bool> $showOn */
	private Collection $showOn;

	public function __construct()
	{
		$this->showOn = collect([
			ResourcePageType::INDEX->name => true,
			ResourcePageType::CREATE->name => true,
			ResourcePageType::EDIT->name => true,
		]);
	}

	public static function make(): self
	{
		return new self();
	}

	/**
	 * @return static
	 */
	public function showOn(ResourcePageType $pageType)
	{
		$this->showOn = $this->showOn->merge([
			$pageType->name => true,
		]);

		return $this;
	}

	/**
	 * @return static
	 */
	public function hideOn(ResourcePageType $pageType)
	{
		$this->showOn = $this->showOn->merge([
			$pageType->name => false,
		]);

		return $this;
	}

	/**
	 * @return static
	 */
	public function onlyOn(ResourcePageType $pageType)
	{
		$this->showOn = collect([
			$pageType->name => true,
		]);

		return $this;
	}

	public function shouldShowOn(ResourcePageType $pageType): bool
	{
		return $this->showOn[$pageType->name] ?? false;
	}
}
