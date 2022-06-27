import React, { useRef } from "react";
import { randomString } from "../../../../../helpers/randomString";
import { FieldInterface } from "../../../../Fields/FieldsInterfaces";
import { hasError } from "../../../../Fields/helpers/hasError";
import { ChoiceButton } from "../../../../Fields/partials/ChoiceButton";
import { FieldError } from "../../../../Fields/partials/FieldError";
import { TextInterface } from "../../Text";
import {
	FieldWrapper,
	WrapperFieldPropsInterface,
} from "./partials/FieldWrapper";

export interface CheckboxFieldInterface
	extends WrapperFieldPropsInterface,
		CheckboxFieldComponentInterface {
	nodeType: "CheckboxField";
}

export const CheckboxField: React.FC<CheckboxFieldInterface> = (props) => (
	<FieldWrapper props={{ ...props }} field={CheckboxFieldComponent} />
);

interface CheckboxFieldComponentInterface extends FieldInterface<boolean> {
	label: string | TextInterface;
	description: string | null;
	required?: boolean;
	disabled?: boolean;
}

const CheckboxFieldComponent: React.FC<CheckboxFieldInterface> = (props) => {
	const {
		name,
		value = false,
		label,
		description,
		disabled = false,
		errors,
		setData,
	} = props;

	const id = useRef(randomString()).current;

	return (
		<div>
			<ChoiceButton id={id} title={label} description={description}>
				<input
					className={`focus:shadow-outline h-4 w-4 rounded border-gray-300 text-primary-600 transition duration-150 focus:ring-offset-0 ${
						hasError({ name, errors })
							? "focus:shadow-outline-red border-red-400"
							: ""
					}`}
					type="checkbox"
					name={name}
					id={id}
					checked={value}
					disabled={disabled}
					onChange={(event) => {
						const checked = event.target.checked;
						setData?.(name, checked);
					}}
				/>
			</ChoiceButton>

			<FieldError {...props} />
		</div>
	);
};
