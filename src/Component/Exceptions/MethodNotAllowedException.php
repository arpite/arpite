<?php

namespace Arpite\Arpite\Component\Exceptions;

use Exception;

class MethodNotAllowedException extends Exception
{
	public function __construct(string $method)
	{
		parent::__construct(
			'Method "' . $method . '" is not allowed on this class.'
		);
	}
}
