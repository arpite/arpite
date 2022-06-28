<?php

namespace Arpite\Arpite\Component\Components\Flex;

use Arpite\Arpite\Component\Component;
use Arpite\Arpite\Component\Components\Flex\Enums\Display;
use Arpite\Arpite\Component\ResponsiveValue;
use Arpite\Arpite\Component\Traits\HasNodes;
use Arpite\Arpite\Core\Utilities\ExportBuilder;

class Flex extends Component
{
	use HasNodes;

	/** @var ResponsiveValue<string> $display */
	private ResponsiveValue $display;

	/** @var ResponsiveValue<string>|null $justifyContent */
	private ResponsiveValue|null $justifyContent = null;

	private ?string $alignItems = null;

	public function __construct()
	{
		$this->display = ResponsiveValue::make(Display::FLEX);
	}

	public static function make(): self
	{
		return new self();
	}

	/**
	 * @param string|null $default
	 * @param string|null $sm
	 * @param string|null $md
	 * @param string|null $lg
	 * @param string|null $xl
	 * @return static
	 */
	public function setDisplay(
		string|null $default = null,
		string|null $sm = null,
		string|null $md = null,
		string|null $lg = null,
		string|null $xl = null
	) {
		$this->display = ResponsiveValue::make($default, $sm, $md, $lg, $xl);

		return $this;
	}

	/**
	 * @param string|null $default
	 * @param string|null $sm
	 * @param string|null $md
	 * @param string|null $lg
	 * @param string|null $xl
	 * @return static
	 */
	public function setJustify(
		string|null $default = null,
		string|null $sm = null,
		string|null $md = null,
		string|null $lg = null,
		string|null $xl = null
	) {
		$this->justifyContent = ResponsiveValue::make(
			$default,
			$sm,
			$md,
			$lg,
			$xl
		);

		return $this;
	}

	/**
	 * @return static
	 */
	public function setAlignStart()
	{
		$this->alignItems = "flex-start";

		return $this;
	}

	/**
	 * @return static
	 */
	public function setAlignEnd()
	{
		$this->alignItems = "flex-end";

		return $this;
	}

	/**
	 * @return static
	 */
	public function setAlignCenter()
	{
		$this->alignItems = "center";

		return $this;
	}

	/**
	 * @return static
	 */
	public function setAlignBaseline()
	{
		$this->alignItems = "baseline";

		return $this;
	}

	/**
	 * @return static
	 */
	public function setAlignStretch()
	{
		$this->alignItems = "stretch";

		return $this;
	}

	/**
	 * @return array<string, mixed>
	 */
	public function export(): array
	{
		return ExportBuilder::make($this)
			->mergeProperties($this->nodesExport())
			->addProperty("display", $this->display)
			->addProperty("justifyContent", $this->justifyContent)
			->addProperty("alignItems", $this->alignItems)
			->export();
	}
}
