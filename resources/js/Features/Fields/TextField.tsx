import React, { useRef } from "react";
import { randomString } from "../../helpers/randomString";
import { FieldInterface } from "./FieldsInterfaces";
import { hasError } from "./helpers/hasError";
import { FieldError } from "./partials/FieldError";
import { FieldLabel } from "./partials/FieldLabel";

export interface TextFieldInterface extends FieldInterface<string | null> {
	label: string;
	type?: "text" | "email" | "password";
	autofocus?: boolean;
}

export const TextField: React.FC<TextFieldInterface> = (props) => {
	const {
		name,
		label,
		type = "text",
		value,
		placeholder,
		autofocus = false,
		required = true,
		disabled = false,
		explanation,
		setData,
	} = props;

	const id = useRef(randomString()).current;

	return (
		<div>
			<FieldLabel id={id} explanation={explanation} required={required}>
				{label}
			</FieldLabel>

			<input
				className={`mt-1 block w-full rounded-md text-sm text-gray-900 placeholder-gray-400 shadow-sm transition duration-150 disabled:bg-gray-100 ${
					hasError(props)
						? "focus:shadow-outline-red border-red-400"
						: "focus:shadow-outline border-gray-300"
				}`}
				type={type}
				name={name}
				id={id}
				value={value ?? ""}
				autoFocus={autofocus}
				placeholder={placeholder ?? ""}
				disabled={disabled}
				onChange={(event) => setData?.(name, event.target.value)}
			/>

			<FieldError {...props} />
		</div>
	);
};
