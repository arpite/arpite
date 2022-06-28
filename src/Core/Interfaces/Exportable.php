<?php

namespace Arpite\Arpite\Core\Interfaces;

interface Exportable
{
	/**
	 * @return array<mixed>
	 */
	public function export(): array;
}
