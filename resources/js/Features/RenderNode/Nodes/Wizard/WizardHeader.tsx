import React from "react";
import { HeaderProgressDesign } from "./HeaderDesigns/HeaderProgressDesign";
import { HeaderStepsDesign } from "./HeaderDesigns/HeaderStepsDesign";

export interface WizardHeaderInterface {
	nodeType: "WizardHeader";
	activeIndex: number;
	design: "STEPS" | "PROGRESS";
	steps: WizardStepInterface[];
}

export interface WizardStepInterface {
	title: string | null;
	index: number;
	active: boolean;
	highlighted: boolean;
}

export const WizardHeader: React.FC<WizardHeaderInterface> = (props) => {
	const Tag =
		props.design === "STEPS" ? HeaderStepsDesign : HeaderProgressDesign;

	return <Tag {...props} />;
};
