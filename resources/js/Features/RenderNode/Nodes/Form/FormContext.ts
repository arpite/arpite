import React from "react";
import { FieldInterface } from "../../../Fields/FieldsInterfaces";
import { FormInterface, SubmitOptionsInterface } from "./Form";

export interface FormContextInterface {
	values: FormInterface["values"];
	loading: boolean;
	submitTriggerId: string | null;
	errors: FieldInterface<unknown>["errors"];
	submit: (options?: SubmitOptionsInterface) => Promise<void>;
	setData: FieldInterface<unknown>["setData"];
	setDataRaw: (
		getNewData: (
			previousData: Record<string, unknown>
		) => Record<string, unknown>
	) => void;
}

const FormContext = React.createContext<FormContextInterface>({
	values: {},
	loading: false,
	submitTriggerId: null,
	errors: {},
	submit: async () => {},
	setData: () => {},
	setDataRaw: () => {},
});

export default FormContext;
