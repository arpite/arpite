<?php

namespace Arpite\Form;

use Arpite\Component\Component;
use Arpite\Component\Components\Table\Actions\GetTableSelectedValuesValidationRulesAction;
use Arpite\Component\Traits\HasActions;
use Arpite\Component\Traits\HasDescription;
use Arpite\Component\Traits\HasNodes;
use Arpite\Component\Traits\HasPreserveScroll;
use Arpite\Component\Traits\HasTitle;
use Arpite\Component\Traits\HasWithPanel;
use Arpite\Core\Utilities\ExportBuilder;
use Arpite\Core\Utilities\NodesUtility;
use Arpite\Form\Actions\GetNestedFieldsDefaultValuesAction;
use Arpite\Form\Actions\GetNestedFieldsValidationRulesAction;
use Arpite\Form\Enums\OperationResponseType;
use Arpite\Form\Form\FormButton;
use Exception;

class Form extends Component
{
	use HasTitle;
	use HasDescription;
	use HasActions;
	use HasNodes;
	use HasPreserveScroll;
	use HasWithPanel;

	/** @var array<string, mixed> $additionalValidationRules */
	private array $additionalValidationRules = [];

	/** @var array<string, mixed> $values */
	private array $values = [];

	private ?Operation $operation = null;

	private string $actionLink;

	/** @var array<int, FormButton> $leftButtons */
	private array $leftButtons = [];

	/** @var array<int, FormButton> $rightButtons */
	private array $rightButtons = [];

	private FormButton $defaultSubmitButton;

	/** @var array<int, Component> */
	private array $stickyHeader = [];

	/**
	 * @throws Exception
	 */
	private function __construct(Operation|string $operationOrActionLink)
	{
		if ($operationOrActionLink instanceof Operation) {
			$this->operation = $operationOrActionLink;
			$this->actionLink = $this->operation->resolveRoute();
		} else {
			$this->actionLink = $operationOrActionLink;
		}

		$this->defaultSubmitButton = FormButton::make()->setTitle("Submit");
		$this->setRightButtons([$this->defaultSubmitButton]);
	}

	public static function make(Operation|string $operationOrLink): self
	{
		return new self($operationOrLink);
	}

	public function setSubmitButtonText(string $submitButtonText): self
	{
		$this->defaultSubmitButton->setTitle($submitButtonText);

		return $this;
	}

	/**
	 * @param array<string, mixed> $values
	 * @return $this
	 */
	public function setValues(array $values): self
	{
		$this->values = $values;

		return $this;
	}

	/**
	 * @param Component[] $stickyHeader
	 * @return $this
	 */
	public function setStickyHeader(array $stickyHeader): self
	{
		$this->stickyHeader = $stickyHeader;

		return $this;
	}

	/**
	 * @param array<int, FormButton|null|bool> $leftButtons
	 * @return $this
	 */
	public function setLeftButtons(array $leftButtons): self
	{
		$this->leftButtons = array_filter(
			$leftButtons,
			fn($node) => $node !== null && $node !== true && $node !== false
		);

		return $this;
	}

	/**
	 * @param array<int, FormButton|null|bool> $rightButtons
	 * @return $this
	 */
	public function setRightButtons(array $rightButtons): self
	{
		$this->rightButtons = array_filter(
			$rightButtons,
			fn($node) => $node !== null && $node !== true && $node !== false
		);

		return $this;
	}

	public function addLeftButtonOnLeft(FormButton $button): self
	{
		$this->setLeftButtons(array_merge([$button], $this->leftButtons));

		return $this;
	}

	public function addLeftButtonOnRight(FormButton $button): self
	{
		$this->setLeftButtons(array_merge($this->leftButtons, [$button]));

		return $this;
	}

	public function addRightButtonOnLeft(FormButton $button): self
	{
		$this->setRightButtons(array_merge([$button], $this->rightButtons));

		return $this;
	}

	public function addRightButtonOnRight(FormButton $button): self
	{
		$this->setRightButtons(array_merge($this->rightButtons, [$button]));

		return $this;
	}

	public function acceptsTableSelectedValues(string $model): self
	{
		$this->additionalValidationRules = array_merge(
			$this->additionalValidationRules,
			app(GetTableSelectedValuesValidationRulesAction::class)->execute(
				$model
			)
		);

		return $this;
	}

	/**
	 * @param object $unvalidatedFormValues
	 * @return array<string, mixed>
	 */
	public function getValidationRules(object $unvalidatedFormValues): array
	{
		$validationRulesFromFields = app(
			GetNestedFieldsValidationRulesAction::class
		)->execute(
			$this->nodes,
			initialFormValues: (object) $this->getValues(),
			unvalidatedFormValues: $unvalidatedFormValues
		);

		return array_merge(
			$validationRulesFromFields,
			$this->additionalValidationRules
		);
	}

	/**
	 * @return array<string, mixed>
	 */
	public function getValues(): array
	{
		$defaultValues = app(
			GetNestedFieldsDefaultValuesAction::class
		)->execute($this->getNodes(), (object) $this->values);

		$valuesWithOnlyNulls = collect($this->values)
			->filter(fn(mixed $value) => $value === null)
			->all();

		$valuesWithoutNull = collect($this->values)
			->filter(fn(mixed $value) => $value !== null)
			->all();

		return array_merge(
			/**
			 * We merge other values on top on null values
			 * in order to keep null values as well.
			 */
			$valuesWithOnlyNulls,
			$defaultValues,
			$valuesWithoutNull
		);
	}

	/**
	 * @return array<mixed>
	 * @throws Exception
	 */
	public function export(): array
	{
		$actionResponseType =
			$this->operation?->getResponseType() ??
			OperationResponseType::REGULAR;

		return ExportBuilder::make($this)
			->mergeProperties($this->titleExport())
			->mergeProperties($this->descriptionExport())
			->mergeProperties($this->actionsExport())
			->mergeProperties($this->nodesExport())
			->mergeProperties($this->preserveScrollExport())
			->mergeProperties($this->withPanelExport())
			->addNodesProperty("leftButtons", $this->leftButtons)
			->addNodesProperty("rightButtons", $this->rightButtons)
			->addNodesProperty("stickyHeader", $this->stickyHeader)
			->addProperty("action", $this->actionLink)
			->addProperty("actionResponseType", $actionResponseType)
			->addProperty("values", $this->getValues())
			->export();
	}
}
