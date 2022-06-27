<?php

namespace SudoBee\Cygnus\Component\Components\Modal;

use SudoBee\Cygnus\Component\Component;
use SudoBee\Cygnus\Component\Components\Modal\Enums\ModalDesign;
use SudoBee\Cygnus\Component\Traits\HasDescription;
use SudoBee\Cygnus\Component\Traits\HasNodes;
use SudoBee\Cygnus\Component\Traits\HasTitle;
use SudoBee\Cygnus\Core\Utilities\ExportBuilder;
use SudoBee\Cygnus\Form\Form;
use Exception;

class Modal extends Component
{
	use HasTitle;
	use HasDescription;
	use HasNodes;

	private string $design = ModalDesign::SIDE;

	private ?Form $form = null;

	public static function make(): self
	{
		return new self();
	}

	/**
	 * @param Form|null $form
	 * @return static
	 */
	public function setForm(?Form $form)
	{
		$this->form = $form;

		return $this;
	}

	/**
	 * @return static
	 */
	public function asSideDesign()
	{
		$this->design = ModalDesign::SIDE;

		return $this;
	}

	/**
	 * @return static
	 */
	public function asPageDesign()
	{
		$this->design = ModalDesign::PAGE;

		return $this;
	}

	private function hasFormInNodes(): bool
	{
		foreach ($this->nodes as $node) {
			if ($node instanceof Form) {
				return true;
			}
		}

		return false;
	}

	/**
	 * @return array<mixed>
	 * @throws Exception
	 */
	public function export(): array
	{
		if (
			($this->title !== null || $this->description !== null) &&
			$this->form !== null
		) {
			throw new Exception(
				"Title and description is not allowed when using form in modal. Set title and description on form instead."
			);
		}

		if ($this->hasFormInNodes()) {
			throw new Exception(
				'Do not pass Form to "setNodes" method, instead use "setForm".'
			);
		}

		return ExportBuilder::make($this)
			->mergeProperties($this->nodesExport())
			->mergeProperties($this->titleExport())
			->mergeProperties($this->descriptionExport())
			->addProperty("design", $this->design)
			->addProperty("form", $this->form)
			->export();
	}
}
