<?php

namespace SudoBee\Cygnus\Component;

use SudoBee\Cygnus\Core\Interfaces\Exportable;
use SudoBee\Cygnus\Core\Utilities\ExportBuilder;

/**
 * @template TValue
 */
class ResponsiveValue implements Exportable
{
	/**
	 * @param TValue|null $default
	 * @param TValue|null $sm
	 * @param TValue|null $md
	 * @param TValue|null $lg
	 * @param TValue|null $xl
	 */
	public function __construct(
		private mixed $default,
		private mixed $sm,
		private mixed $md,
		private mixed $lg,
		private mixed $xl
	) {
	}

	/**
	 * @param TValue|null $default
	 * @param TValue|null $sm
	 * @param TValue|null $md
	 * @param TValue|null $lg
	 * @param TValue|null $xl
	 * @return static<TValue>
	 */
	public static function make(
		mixed $default = null,
		mixed $sm = null,
		mixed $md = null,
		mixed $lg = null,
		mixed $xl = null
	): self {
		return new self($default, $sm, $md, $lg, $xl);
	}

	public function export(): array
	{
		return ExportBuilder::make()
			->addPropertyIf($this->default !== null, "d", $this->default)
			->addPropertyIf($this->sm !== null, "sm", $this->sm)
			->addPropertyIf($this->md !== null, "md", $this->md)
			->addPropertyIf($this->lg !== null, "lg", $this->lg)
			->addPropertyIf($this->xl !== null, "xl", $this->xl)
			->export();
	}
}
