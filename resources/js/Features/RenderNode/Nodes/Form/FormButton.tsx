import React, { useContext, useRef } from "react";
import { randomString } from "../../../../helpers/randomString";
import { Button, ButtonInterface } from "../../../Button";
import FormContext from "./FormContext";

export interface FormButtonInterface {
	nodeType: "FormButton";
	title: string | null;
	color: ButtonInterface["color"];
	design: ButtonInterface["design"];
	forceActionResponseType: "REGULAR" | "JSON" | null;
	withData: Record<string, unknown>;
	withoutFrontendValidation: boolean;
}

export const FormButton: React.FC<FormButtonInterface> = ({
	title,
	color,
	design,
	forceActionResponseType,
	withData,
	withoutFrontendValidation,
}) => {
	const id = useRef(randomString()).current;

	const {
		submit,
		loading: loadingForm,
		submitTriggerId,
	} = useContext(FormContext);

	const loading =
		loadingForm &&
		(id === submitTriggerId ||
			(submitTriggerId === null && design === "primary"));

	return (
		<Button
			design={design}
			color={color}
			silentDisabled={loadingForm}
			loading={loading}
			onClick={() => {
				submit({
					triggerId: id,
					withoutValidation: withoutFrontendValidation,
					actionResponseType: forceActionResponseType,
					withData,
				});
			}}
		>
			{title}
		</Button>
	);
};
