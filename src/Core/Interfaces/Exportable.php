<?php

namespace SudoBee\Cygnus\Core\Interfaces;

interface Exportable
{
	/**
	 * @return array<mixed>
	 */
	public function export(): array;
}
