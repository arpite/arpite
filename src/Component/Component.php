<?php

namespace Arpite\Component;

use Arpite\Core\Interfaces\Exportable;

abstract class Component implements Exportable
{
	/**
	 * @return array<mixed>
	 */
	abstract public function export(): array;

	/**
	 * @param bool $show
	 * @return array<int, static>
	 * @deprecated
	 */
	#[Deprecated("use ternary operator instead")]
	public function show(bool $show) {
		if ($show) {
			return [$this];
		}

		return [];
	}
}
