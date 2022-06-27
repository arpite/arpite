import React from "react";
import {
	NumberField as NumberFieldComponent,
	NumberFieldInterface as NumberFieldComponentInterface,
} from "../../../../Fields/NumberField";
import {
	FieldWrapper,
	WrapperFieldPropsInterface,
} from "./partials/FieldWrapper";

export interface NumberFieldInterface
	extends WrapperFieldPropsInterface,
		NumberFieldComponentInterface {
	nodeType: "NumberField";
}

export const NumberField: React.FC<NumberFieldInterface> = (props) => (
	<FieldWrapper props={props} field={NumberFieldComponent} />
);
