import React from "react";
import { useTranslation } from "react-i18next";
import { WizardHeaderInterface, WizardStepInterface } from "../WizardHeader";

export const HeaderStepsDesign: React.FC<WizardHeaderInterface> = ({
	steps,
}) => (
	<div className="flex border-b border-gray-200 p-4 sm:space-x-6 sm:p-6">
		{steps.map((step) => (
			<Step key={step.index} {...step} total={steps.length} />
		))}
	</div>
);

interface WizardRegularStepInterface extends WizardStepInterface {
	total: number;
}

const Step: React.FC<WizardRegularStepInterface> = ({
	title,
	index,
	active,
	highlighted,
	total,
}) => {
	const { t } = useTranslation();

	return (
		<div
			className={`duration-400 flex-1 border-t-4 pt-2 transition ${
				highlighted ? "border-primary-600" : "border-gray-200"
			} ${active ? "" : "hidden sm:block"}`}
		>
			<h5
				className={`duration-400 text-xs font-semibold uppercase transition ${
					highlighted ? "text-primary-600" : "text-gray-500"
				}`}
			>
				{t("Step")} {index + 1}{" "}
				<span className="sm:hidden">
					{t("of")} {total}
				</span>
			</h5>

			{title !== null && (
				<h4 className="text-sm font-medium text-gray-800">{title}</h4>
			)}
		</div>
	);
};
