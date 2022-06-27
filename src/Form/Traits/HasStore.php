<?php

namespace SudoBee\Cygnus\Form\Traits;

use App\Cygnus\OperationStore;

trait HasStore
{
	protected OperationStore $store;

	final protected function initStore(): void
	{
		$this->store = new OperationStore();
	}
}
