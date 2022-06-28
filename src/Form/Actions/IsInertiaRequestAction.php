<?php

namespace Arpite\Arpite\Form\Actions;

use Illuminate\Http\Request;

class IsInertiaRequestAction
{
	public function execute(Request $request): bool
	{
		return $request->headers->get("X-Inertia") !== null;
	}
}
