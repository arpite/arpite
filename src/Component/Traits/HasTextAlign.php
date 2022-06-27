<?php

namespace SudoBee\Cygnus\Component\Traits;

use SudoBee\Cygnus\Component\ResponsiveValue;
use SudoBee\Cygnus\Core\Utilities\ExportBuilder;

trait HasTextAlign
{
	/**
	 * @var ResponsiveValue<string>|null $justifyContent
	 * @phpstan-ignore-next-line
	 */
	private ResponsiveValue|null $textAlign = null;

	/**
	 * @param string|null $default
	 * @param string|null $sm
	 * @param string|null $md
	 * @param string|null $lg
	 * @param string|null $xl
	 * @return static
	 */
	public function setTextAlign(
		string|null $default,
		string|null $sm = null,
		string|null $md = null,
		string|null $lg = null,
		string|null $xl = null
	) {
		$this->textAlign = ResponsiveValue::make($default, $sm, $md, $lg, $xl);

		return $this;
	}

	/**
	 * @return array<mixed>
	 */
	private function textAlignExport(): array
	{
		return ExportBuilder::make()
			->addProperty("textAlign", $this->textAlign)
			->export();
	}
}
