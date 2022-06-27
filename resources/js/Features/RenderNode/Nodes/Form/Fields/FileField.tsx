import React from "react";
import {
	FileField as FileFieldComponent,
	FileFieldInterface as FileFieldComponentInterface,
} from "../../../../Fields/FileField";
import {
	FieldWrapper,
	WrapperFieldPropsInterface,
} from "./partials/FieldWrapper";

export interface FileFieldInterface
	extends WrapperFieldPropsInterface,
		FileFieldComponentInterface {
	nodeType: "FileField";
}

export const FileField: React.FC<FileFieldInterface> = (props) => (
	<FieldWrapper props={props} field={FileFieldComponent} />
);
