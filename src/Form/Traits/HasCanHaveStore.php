<?php

namespace Arpite\Form\Traits;

trait HasCanHaveStore
{
	final protected function bootHasCanHaveStore(): void
	{
		if (method_exists($this, "initStore")) {
			$this->initStore();
		}
	}

	final protected function updateStore(): void
	{
		if (property_exists($this, "store")) {
			$this->store->update();
		}
	}
}
