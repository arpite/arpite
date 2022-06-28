<?php

namespace Arpite\Arpite\Form\Traits;

use App\Arpite\OperationStore;

trait HasStore
{
	protected OperationStore $store;

	final protected function initStore(): void
	{
		$this->store = new OperationStore();
	}
}
