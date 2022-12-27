import React, { useRef } from "react";
import { randomString } from "../../helpers/randomString";
import { FieldInterface } from "./FieldsInterfaces";
import { hasError } from "./helpers/hasError";
import { FieldError } from "./partials/FieldError";
import { FieldLabel } from "./partials/FieldLabel";

export interface TextareaFieldInterface extends FieldInterface<string | null> {
	label: string;
	height: number;
	resizable: boolean;
}

export const TextareaField: React.FC<TextareaFieldInterface> = (props) => {
	const {
		name,
		label,
		value,
		placeholder,
		required = true,
		disabled = false,
		explanation,
		height,
		resizable,
		setData,
	} = props;

	const id = useRef(randomString()).current;

	return (
		<div>
			<FieldLabel id={id} explanation={explanation} required={required}>
				{label}
			</FieldLabel>

			<textarea
				className={`mt-1 block w-full rounded-md text-sm text-gray-900 placeholder-gray-400 shadow-sm transition duration-150 disabled:bg-gray-100 ${
					hasError(props)
						? "focus:shadow-outline-red border-red-400"
						: "focus:shadow-outline border-gray-300"
				} ${resizable ? "resize-y" : "resize-none"}`}
				style={{ minHeight: `${height}px` }}
				name={name}
				id={id}
				value={value ?? ""}
				placeholder={placeholder ?? ""}
				disabled={disabled}
				onChange={(event) => setData?.(name, event.target.value)}
			/>

			<FieldError {...props} />
		</div>
	);
};
