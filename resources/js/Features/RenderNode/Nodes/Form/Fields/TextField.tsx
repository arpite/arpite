import React from "react";
import {
	TextField as TextFieldComponent,
	TextFieldInterface as TextFieldComponentInterface,
} from "../../../../Fields/TextField";
import {
	FieldWrapper,
	WrapperFieldPropsInterface,
} from "./partials/FieldWrapper";

export interface TextFieldInterface
	extends WrapperFieldPropsInterface,
		TextFieldComponentInterface {
	nodeType: "TextField";
}

export const TextField: React.FC<TextFieldInterface> = (props) => (
	<FieldWrapper props={props} field={TextFieldComponent} />
);
