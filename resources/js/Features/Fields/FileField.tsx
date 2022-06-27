import { mdiClose } from "@mdi/js";
import React, { useRef } from "react";
import { useTranslation } from "react-i18next";
import { randomString } from "../../helpers/randomString";
import { Icon } from "../Icon";
import { FieldInterface } from "./FieldsInterfaces";
import { hasError } from "./helpers/hasError";
import { FieldError } from "./partials/FieldError";
import { FieldLabel } from "./partials/FieldLabel";

interface FileEntityInterface {
	identifier: string | number;
	title: string;
}

export interface FileFieldInterface
	extends FieldInterface<(File | FileEntityInterface)[]> {
	label: string;
	acceptedExtensions: string[];
}

export const FileField: React.FC<FileFieldInterface> = ({
	name,
	label,
	value,
	required = true,
	disabled = false,
	errors: givenErrors,
	explanation,
	acceptedExtensions,
	setData,
}) => {
	const { t } = useTranslation();

	const errors = {
		...givenErrors,
		[name]: givenErrors?.[name] ?? givenErrors?.[`${name}.0`] ?? "",
	};

	const filename =
		value.length === 0
			? null
			: value[0] instanceof File
			? value[0].name
			: value[0].title; // Currently we only support 1 file

	const showClearButton = !required && !disabled && filename !== null;

	const errorClassName = hasError({ name, errors })
		? "border-red-400 focus:shadow-outline-red"
		: "border-gray-300 focus:shadow-outline";

	const id = useRef(randomString()).current;
	const refInput = useRef<HTMLInputElement>(null);

	const clear = () => {
		setData?.(name, []);
		if (refInput.current !== null) {
			refInput.current.value = "";
		}
	};

	return (
		<div>
			<FieldLabel id={id} explanation={explanation} required={required}>
				{label}
			</FieldLabel>

			<div
				className={`relative mt-1 flex h-9 w-full items-stretch rounded-md text-sm text-gray-900 shadow-sm transition duration-150 ${
					disabled ? "bg-gray-100" : ""
				}`}
			>
				<button
					type="button"
					className={`flex flex-none select-none items-center rounded-l-md border px-3 transition duration-150 hover:bg-gray-100 ${errorClassName}`}
					disabled={disabled}
					onClick={() => {
						refInput.current?.click();
					}}
				>
					<input
						ref={refInput}
						className="hidden"
						type="file"
						name={name}
						id={id}
						accept={`.${acceptedExtensions.join(",.")}`}
						disabled={disabled}
						onChange={(event) => {
							const newFile = event.target.files?.[0] ?? null;
							if (newFile !== null) {
								setData?.(name, [newFile]);
							}
						}}
					/>

					<span>
						{filename === null
							? t("Choose file")
							: t("Change file")}
					</span>
				</button>

				<div
					className={`flex flex-1 items-center overflow-hidden rounded-r-md border-r border-t border-b pl-3 text-gray-600 transition  duration-150 ${
						showClearButton ? "pr-10" : "pr-3"
					} ${errorClassName}`}
				>
					<span
						className={`truncate ${
							filename === null ? "text-gray-400" : ""
						}`}
					>
						{filename === null ? t("No file chosen") : filename}
					</span>
				</div>

				{showClearButton && (
					<button
						type="button"
						className="absolute inset-y-0 right-0 ml-3 flex items-center pr-2"
						onClick={(event) => {
							event.stopPropagation();
							clear();
						}}
					>
						<Icon
							icon={mdiClose}
							className="h-5 w-5 cursor-pointer text-gray-400 transition duration-150 hover:text-gray-500"
							aria-hidden="true"
						/>
					</button>
				)}
			</div>

			<FieldError name={name} errors={errors} />
		</div>
	);
};
