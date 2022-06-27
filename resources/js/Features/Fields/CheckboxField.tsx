import React from "react";
import { FieldInterface } from "./FieldsInterfaces";
import { hasError } from "./helpers/hasError";
import { FieldError } from "./partials/FieldError";

export interface CheckboxFieldInterface
	extends FieldInterface<boolean | string> {
	required?: boolean;
	disabled?: boolean;
}

export const CheckboxField: React.FC<CheckboxFieldInterface> = (props) => {
	const {
		name,
		value = false,
		disabled = false,
		errors,
		setData,
		children,
	} = props;

	return (
		<div>
			<div className="flex items-center">
				<input
					className={`focus:shadow-outline h-4 w-4 rounded border-gray-300 text-primary-600 transition duration-150 focus:ring-offset-0 ${
						hasError({ name, errors })
							? "focus:shadow-outline-red border-red-400"
							: ""
					}`}
					type="checkbox"
					name={name}
					id={name}
					checked={typeof value === "string" ? value !== "" : value}
					disabled={disabled}
					onChange={(event) => {
						const checked = event.target.checked;
						setData?.(
							name,
							typeof value === "string"
								? checked
									? name
									: ""
								: checked
						);
					}}
				/>
				<label
					htmlFor={name}
					className="ml-2 block text-sm text-gray-900"
				>
					{children}
				</label>
			</div>
			<FieldError {...props} />
		</div>
	);
};
