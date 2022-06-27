<?php

namespace SudoBee\Cygnus\Component;

use SudoBee\Cygnus\Core\Interfaces\Exportable;

abstract class Component implements Exportable
{
	/**
	 * @return array<mixed>
	 */
	abstract public function export(): array;

	/**
	 * @param bool $show
	 * @return array<int, static>
	 */
	public function show(bool $show)
	{
		if ($show) {
			return [$this];
		}

		return [];
	}
}
