<?php

namespace SudoBee\Cygnus\Form\Fields;

use SudoBee\Cygnus\Component\Rules\DeepExistInRule;
use SudoBee\Cygnus\Core\Utilities\ExportBuilder;
use SudoBee\Cygnus\Form\Fields\Classes\FileEntity;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

/**
 * @extends Field<array<int, FileEntity>>
 */
class FileField extends Field
{
	/**
	 * @var Collection<int, mixed> $fileValidationRules
	 */
	private Collection $fileValidationRules;

	/**
	 * @var array<int, string> $acceptedExtensions
	 */
	private array $acceptedExtensions = [];

	private function __construct(string $label, ?string $name = null)
	{
		parent::__construct($label, $name);

		$this->setDefaultValue([]);

		$this->addValidationRule("array");
		$this->addValidationRule("max:1");

		$this->fileValidationRules = collect([
			"file",
			"max:" . 3 * 1024, // in kilobytes (kB)
		]);
		$this->acceptOnlyImages();
	}

	public static function make(string $label, ?string $name = null): self
	{
		return new self($label, $name);
	}

	/**
	 * @param array<int, FileEntity> $defaultValue
	 * @return static
	 */
	public function setDefaultValue($defaultValue)
	{
		parent::setDefaultValue(
			/** @phpstan-ignore-next-line  */
			collect($defaultValue)
				->map(fn(FileEntity $value) => $value->export())
				->all()
		);

		return $this;
	}

	public function getValidationRules(object $formValues): array
	{
		$name = $this->getName();

		return array_merge(parent::getValidationRules($formValues), [
			$name . ".*" => [
				"required",
				function (string $attribute, mixed $value, $fail) use ($name) {
					$rules =
						$value instanceof UploadedFile
							? $this->fileValidationRules->all()
							: [
								new DeepExistInRule(
									$this->getDefaultValue()[$name]
								),
							];

					try {
						Validator::validate(
							["field" => $value],
							["field" => $rules]
						);
					} catch (ValidationException $exception) {
						$fail($exception->errors()["field"]);
					}
				},
			],
		]);
	}

	/**
	 * @param int $kilobytes
	 * @return static
	 */
	public function setMaxSize(int $kilobytes)
	{
		$this->fileValidationRules = $this->fileValidationRules->filter(
			fn(mixed $rule) => !is_string($rule) ||
				!Str::startsWith($rule, "max:")
		);

		$this->fileValidationRules->push("max:" . $kilobytes);

		return $this;
	}

	/**
	 * @return static
	 */
	public function acceptOnlyImages()
	{
		$this->setAcceptedExtensions(["jpg", "jpeg", "png", "bmp"]);

		return $this;
	}

	/**
	 * @description All possible extensions can be found here: https://svn.apache.org/repos/asf/httpd/httpd/trunk/docs/conf/mime.types
	 *
	 * @param array<int, string> $acceptedExtensions
	 * @return static
	 */
	public function setAcceptedExtensions(array $acceptedExtensions)
	{
		$this->fileValidationRules = $this->fileValidationRules->filter(
			fn(mixed $rule) => !is_string($rule) ||
				!Str::startsWith($rule, "mimes:")
		);

		$this->fileValidationRules->push(
			"mimes:" . implode(",", $acceptedExtensions)
		);

		$this->acceptedExtensions = $acceptedExtensions;

		return $this;
	}

	/**
	 * @return array<mixed>
	 */
	public function export(): array
	{
		return ExportBuilder::make($this)
			->mergeProperties($this->fieldExport())
			->addProperty("acceptedExtensions", $this->acceptedExtensions)
			->export();
	}
}
