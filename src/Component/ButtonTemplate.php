<?php

namespace SudoBee\Cygnus\Component;

use SudoBee\Cygnus\Component\Components\Alert\Alert;
use SudoBee\Cygnus\Component\Components\Modal\Modal;
use SudoBee\Cygnus\Component\Traits\HasAction;
use SudoBee\Cygnus\Component\Traits\HasButtonColor;
use SudoBee\Cygnus\Component\Traits\HasTitle;
use SudoBee\Cygnus\Core\Utilities\ExportBuilder;
use SudoBee\Cygnus\Form\Operation;
use SudoBee\Cygnus\Page\Page;
use SudoBee\Cygnus\Page\Utilities\Link;

abstract class ButtonTemplate extends Component
{
	use HasTitle;
	use HasAction;
	use HasButtonColor;

	private ?string $type = "button";

	private ?string $link = null;

	private ?string $nodesAction = null;

	private bool $blank = false;

	private ?Alert $actionAlert = null;

	private ?Modal $modal = null;

	/**
	 * @param string|null $link
	 * @return static
	 */
	public function setLink(?string $link)
	{
		$this->link = $link;

		return $this;
	}

	/**
	 * @param class-string<Operation|Page> $class
	 * @param array<string, string | number> $parameters
	 * @return static
	 */
	public function toPage(string $class, array $parameters = [])
	{
		$this->setLink(Link::toPage($class, $parameters));

		return $this;
	}

	/**
	 * @param bool $blank
	 * @return static
	 */
	public function blank(bool $blank = true)
	{
		$this->blank = $blank;

		return $this;
	}

	/**
	 * @param Alert|null $alert
	 * @return static
	 */
	public function setActionConfirm(?Alert $alert)
	{
		$this->actionAlert = $alert;

		return $this;
	}

	/**
	 * @param Modal|null $modal
	 * @return static
	 */
	public function opensModal(?Modal $modal)
	{
		$this->modal = $modal;

		return $this;
	}

	/**
	 * @param string|null $nodesAction
	 * @return static
	 */
	public function setNodesAction(?string $nodesAction)
	{
		$this->nodesAction = $nodesAction;

		return $this;
	}

	/**
	 * @param bool $submit
	 * @return static
	 */
	public function asSubmit(bool $submit = true)
	{
		$this->type = $submit ? "submit" : "button";

		return $this;
	}

	/**
	 * @return static
	 */
	public function asDelete()
	{
		return $this->setTitle("Delete")
			->asColorRed()
			->setActionConfirm(
				Alert::make()
					->setTitle("Are you sure?")
					->setDescription(
						'This action will permanently delete this entity and you won\'t be able to recover it later.'
					)
					->setConfirmButtonText("Delete")
			);
	}

	/**
	 * @return array<mixed>
	 */
	protected function buttonTemplateExport(): array
	{
		return ExportBuilder::make()
			->mergeProperties($this->titleExport())
			->mergeProperties($this->actionExport())
			->mergeProperties($this->buttonColorExport())
			->addProperty("actionAlert", $this->actionAlert)
			->addProperty("modal", $this->modal)
			->addProperty("type", $this->type)
			->addProperty("link", $this->link)
			->addProperty("blank", $this->blank)
			->addProperty("nodesAction", $this->nodesAction)
			->export();
	}
}
