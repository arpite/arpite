import React from "react";
import {
	TagsField as TagsFieldComponent,
	TagsFieldInterface as TagsFieldComponentInterface,
} from "../../../../Fields/TagsField";
import {
	FieldWrapper,
	WrapperFieldPropsInterface,
} from "./partials/FieldWrapper";

export interface TagsFieldInterface
	extends WrapperFieldPropsInterface,
		TagsFieldComponentInterface {
	nodeType: "TagsField";
}

export const TagsField: React.FC<TagsFieldInterface> = (props) => (
	<FieldWrapper props={props} field={TagsFieldComponent} />
);
