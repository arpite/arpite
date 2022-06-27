import React from "react";
import { FieldInterface } from "../FieldsInterfaces";
import { hasError } from "../helpers/hasError";

export interface FieldErrorInterface
	extends Pick<FieldInterface<unknown>, "name" | "errors"> {
	position?: "relative" | "absolute";
}

export const FieldError: React.FC<FieldErrorInterface> = ({
	position = "absolute",
	name,
	errors,
}) => {
	if (errors !== undefined && hasError({ name, errors })) {
		return (
			<div
				className={`w-full text-xs text-red-500 ${
					position === "absolute" ? "mt-[-16px] mb-[-18px]" : ""
				}`}
			>
				{position === "absolute" ? (
					<div className="mt-[18px]">{errors[name]}</div>
				) : (
					errors[name]
				)}
			</div>
		);
	}

	return <></>;
};
