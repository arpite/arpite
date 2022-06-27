import React from "react";
import { WizardHeaderInterface } from "../WizardHeader";

export const HeaderProgressDesign: React.FC<WizardHeaderInterface> = ({
	activeIndex,
	steps,
}) => (
	<div className="h-[3px] w-full">
		<div
			className="h-full bg-primary-600"
			style={{
				width: `${
					Math.round(((activeIndex + 1) / steps.length) * 10000) / 100
				}%`,
			}}
		/>
	</div>
);
