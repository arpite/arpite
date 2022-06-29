<?php

namespace Arpite\ResourceFieldConfiguration\Traits;

use Arpite\ResourceFieldConfiguration\ResourceFieldConfiguration;
use Arpite\Resource\Enums\ResourcePageType;

trait HasResourceConfigurations
{
	private ResourceFieldConfiguration $resourceFieldConfiguration;

	private function bootHasResourceConfigurations(): void
	{
		$this->resourceFieldConfiguration = ResourceFieldConfiguration::make();
	}

	/**
	 * @return static
	 */
	public function showOnIndex()
	{
		$this->resourceFieldConfiguration->showOn(ResourcePageType::INDEX);

		return $this;
	}

	/**
	 * @return static
	 */
	public function showOnCreate()
	{
		$this->resourceFieldConfiguration->showOn(ResourcePageType::CREATE);

		return $this;
	}

	/**
	 * @return static
	 */
	public function showOnEdit()
	{
		$this->resourceFieldConfiguration->showOn(ResourcePageType::EDIT);

		return $this;
	}

	/**
	 * @return static
	 */
	public function hideOnIndex()
	{
		$this->resourceFieldConfiguration->hideOn(ResourcePageType::INDEX);

		return $this;
	}

	/**
	 * @return static
	 */
	public function hideOnCreate()
	{
		$this->resourceFieldConfiguration->hideOn(ResourcePageType::CREATE);

		return $this;
	}

	/**
	 * @return static
	 */
	public function hideOnEdit()
	{
		$this->resourceFieldConfiguration->hideOn(ResourcePageType::EDIT);

		return $this;
	}

	/**
	 * @return static
	 */
	public function onlyOnIndex()
	{
		$this->resourceFieldConfiguration->onlyOn(ResourcePageType::INDEX);

		return $this;
	}

	/**
	 * @return static
	 */
	public function onlyOnCreate()
	{
		$this->resourceFieldConfiguration->onlyOn(ResourcePageType::CREATE);

		return $this;
	}

	/**
	 * @return static
	 */
	public function onlyOnEdit()
	{
		$this->resourceFieldConfiguration->onlyOn(ResourcePageType::EDIT);

		return $this;
	}

	public function shouldShowOn(ResourcePageType $pageType): bool
	{
		return $this->resourceFieldConfiguration->shouldShowOn($pageType);
	}
}
