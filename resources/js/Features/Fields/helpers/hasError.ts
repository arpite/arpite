import { FieldErrorInterface } from "../partials/FieldError";

export const hasError = ({ name, errors }: FieldErrorInterface) => {
	return (
		errors !== undefined &&
		errors[name] !== undefined &&
		errors[name].trim() !== ""
	);
};
