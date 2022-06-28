<?php

namespace Arpite\Arpite\Resource;

use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Inertia\Response;
use LogicException;
use Arpite\Arpite\Core\Traits\HasRegisterRoutes;
use Arpite\Arpite\Core\Traits\HasResolveHelpers;
use Arpite\Arpite\Core\Utilities\Notification;
use Arpite\Arpite\Core\Utilities\RouteUtility;
use Arpite\Arpite\Core\Utilities\Translate;
use Arpite\Arpite\Form\Fields\Field;
use Arpite\Arpite\Resource\Actions\HandleResourceRouteIndexAction;
use Arpite\Arpite\Resource\Enums\ResourcePageType;
use Arpite\Arpite\Resource\Traits\HasResourceFields;
use Arpite\Arpite\Resource\Factories\ResourceFormFactory;
use Arpite\Arpite\Form\Form;
use Arpite\Arpite\Form\Traits\HasCanHaveStore;
use Arpite\Arpite\Responses\StructuredPageResponse;

/**
 * @template TModelClass of Model
 */
abstract class Resource
{
	use HasRegisterRoutes, HasCanHaveStore, HasResolveHelpers;
	use HasResourceFields;

	/** @var class-string<TModelClass> $model */
	protected string $model;

	/** @var Builder<TModelClass>|BelongsTo<Model, TModelClass>|HasMany<TModelClass> $query */
	private Builder|BelongsTo|HasMany $query;

	/** @var TModelClass $modelInstance */
	private Model $modelInstance;

	private function __construct()
	{
		$this->bootHasCanHaveStore();

		if (!isset($this->model)) {
			throw new LogicException(
				"Property \$model must be defined in " .
					get_called_class() .
					" class."
			);
		}
	}

	/**
	 * @param Builder<TModelClass> $query
	 * @return Builder<TModelClass>|BelongsTo<Model, TModelClass>|HasMany<TModelClass>
	 */
	protected function query(Builder $query): Builder|BelongsTo|HasMany
	{
		return $query;
	}

	protected function getRouteKeyName(): string
	{
		return $this->getModelInstance()->getRouteKeyName();
	}

	/**
	 * @return TModelClass
	 */
	private function getModelInstance(): Model
	{
		if (!isset($this->modelInstance)) {
			$model = $this->model;

			$this->modelInstance = new $model();
		}

		return $this->modelInstance;
	}

	/**
	 * @return Builder<TModelClass>|BelongsTo<Model, TModelClass>|HasMany<TModelClass>
	 */
	private function getQuery(): Builder|BelongsTo|HasMany
	{
		if (!isset($this->query)) {
			$rawQuery = $this->model::query();

			$this->query = $this->query($rawQuery);
		}

		return $this->query;
	}

	/**
	 * @param array<string, mixed> $validated
	 * @return array<string, mixed>
	 */
	protected function parseValidated(array $validated): array
	{
		return $validated;
	}

	public function registerRoutes(): void
	{
		$modelCamelName = $this->getModelCamel();

		RouteUtility::get(
			$this->createRouteLink(),
			fn() => $this->handleIndex()
		);

		RouteUtility::get(
			$this->createRouteLink("/create"),
			fn() => $this->handleCreate()
		);
		RouteUtility::get(
			$this->createRouteLink("/{" . $modelCamelName . "}/edit"),
			fn() => $this->handleEdit()
		);

		RouteUtility::post(
			$this->createRouteLink("/create"),
			fn(Request $request) => $this->handleInsert($request)
		);
		RouteUtility::post(
			$this->createRouteLink("/{" . $modelCamelName . "}/update"),
			fn(Request $request) => $this->handleUpdate($request)
		);
		RouteUtility::post(
			$this->createRouteLink("/{" . $modelCamelName . "}/delete"),
			fn() => $this->handleDelete()
		);
	}

	/**
	 * @throws Exception
	 */
	private function handleIndex(): Response
	{
		$this->updateStore();

		return app(HandleResourceRouteIndexAction::class)->execute(
			response: $this->buildResponse(),
			query: $this->getQuery(),
			columns: $this->getFieldsFor(ResourcePageType::INDEX)
				->mapWithKeys(
					fn(Field $field) => [
						$field->getName() => $field->getLabel(),
					]
				)
				->all(),
			modelHeadline: $this->getModelHeadline(),
			routeCreateLink: $this->createRouteLink("/create"),
			routeEditLink: $this->createRouteLink("/{model}/edit"),
			routeDeleteLink: $this->createRouteLink("/{model}/delete"),
			modelRouteKeyName: $this->getRouteKeyName()
		);
	}

	private function handleCreate(): Response
	{
		return $this->buildResponse()
			->setNodes([$this->getCreateForm()])
			->export();
	}

	/**
	 * @throws Exception
	 */
	private function handleEdit(): Response
	{
		return $this->buildResponse()
			->setNodes([$this->getEditForm()])
			->export();
	}

	/**
	 * @throws Exception
	 */
	private function handleInsert(Request $request): RedirectResponse
	{
		$this->updateStore();

		$validated = $this->validate(
			request: $request,
			form: $this->getCreateForm()
		);

		$this->getQuery()->create($this->parseValidated($validated));

		Notification::success(
			$this->getModelHeadline() .
				" " .
				Translate::text("has been created.")
		);

		return redirect()->to($this->createRouteLink());
	}

	/**
	 * @throws Exception
	 */
	private function handleUpdate(Request $request): RedirectResponse
	{
		$this->updateStore();
		$entity = $this->resolveEntity();

		$validated = $this->validate(
			request: $request,
			form: $this->getEditForm()
		);

		$entity->update($this->parseValidated($validated));

		Notification::success(
			$this->getModelHeadline() .
				" " .
				Translate::text("has been updated.")
		);

		return redirect()->to($this->createRouteLink());
	}

	private function handleDelete(): RedirectResponse
	{
		$this->updateStore();

		$this->resolveEntity()->delete();

		Notification::success(
			$this->getModelHeadline() .
				" " .
				Translate::text("has been deleted.")
		);

		return redirect()->to($this->createRouteLink());
	}

	private function getCreateForm(): Form
	{
		$this->updateStore();

		return ResourceFormFactory::make(
			entity: null,
			fields: $this->getFieldsFor(ResourcePageType::CREATE),
			actionLink: $this->createRouteLink("/create"),
			modelHeadline: $this->getModelHeadline()
		);
	}

	/**
	 * @throws Exception
	 */
	private function getEditForm(): Form
	{
		$this->updateStore();

		$entity = $this->resolveEntity();

		return ResourceFormFactory::make(
			entity: $entity,
			fields: $this->getFieldsFor(ResourcePageType::EDIT),
			actionLink: $this->createRouteLink(
				"/" . $entity->{$this->getRouteKeyName()} . "/update"
			),
			modelHeadline: $this->getModelHeadline()
		);
	}

	private function resolveEntity(): Model
	{
		return $this->resolve(
			class: $this->model,
			query: $this->getQuery(),
			modelRouteKeyName: $this->getRouteKeyName()
		);
	}

	/**
	 * @param Request $request
	 * @param Form $form
	 * @return array<string, mixed>
	 * @throws Exception
	 */
	private function validate(Request $request, Form $form): array
	{
		$inputs = $request->all();

		return Validator::validate(
			$inputs,
			$form->getValidationRules((object) $inputs)
		);
	}

	private function createRouteLink(string $subLink = ""): string
	{
		return "/" .
			((string) Str::of($this->getModelBasename())
				->plural()
				->kebab()) .
			$subLink;
	}

	private function getModelBasename(): string
	{
		return Str::of($this->model)->classBasename();
	}

	private function getModelHeadline(): string
	{
		return Str::of($this->getModelBasename())
			->headline()
			->lower()
			->ucfirst();
	}

	private function getModelCamel(): string
	{
		return Str::of($this->getModelBasename())->camel();
	}

	private function buildResponse(): StructuredPageResponse
	{
		$pageTitle = Str::of($this->getModelHeadline())->plural();

		return StructuredPageResponse::make()->setTitle($pageTitle);
	}
}
