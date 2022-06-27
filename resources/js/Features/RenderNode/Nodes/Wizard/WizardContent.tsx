import React, { useContext } from "react";
import { NodeType } from "../../NodeType";
import { RenderNodes } from "../../RenderNodes";
import FormContext from "../Form/FormContext";
import ModalEventsContext from "../Modal/ModalEventsContext";

export interface WizardContentInterface {
	nodeType: "WizardContent";
	nodes: NodeType[];
}

export const WizardContent: React.FC<WizardContentInterface> = ({ nodes }) => {
	const { submit } = useContext(FormContext);

	const reloadStep = async () => {
		await submit({
			withoutValidation: true,
			withData: {
				submitAction: "reload",
			},
		});
	};

	return (
		<ModalEventsContext.Provider value={{ onSubmitSuccess: reloadStep }}>
			<RenderNodes nodes={nodes} />
		</ModalEventsContext.Provider>
	);
};
