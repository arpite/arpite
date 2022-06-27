import React from "react";
import {
	TextareaField as TextareaFieldComponent,
	TextareaFieldInterface as TextareaFieldComponentInterface,
} from "../../../../Fields/TextareaField";
import {
	FieldWrapper,
	WrapperFieldPropsInterface,
} from "./partials/FieldWrapper";

export interface TextareaFieldInterface
	extends WrapperFieldPropsInterface,
		TextareaFieldComponentInterface {
	nodeType: "TextareaField";
}

export const TextareaField: React.FC<TextareaFieldInterface> = (props) => (
	<FieldWrapper props={props} field={TextareaFieldComponent} />
);
