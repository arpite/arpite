import React, { useState } from "react";
import { useTranslation } from "react-i18next";
import { ToggleField } from "../../../Fields/ToggleField";
import { Panel } from "../../../Panel/Panel";
import { PricingPlan, PricingPlanInterface } from "./PricingPlan";
import PricingPlansContext, {
	PricingPlansContextInterface,
} from "./PricingPlansContext";

export interface PricingPlansInterface {
	nodeType: "PricingPlans";
	title: string | null;
	description: string | null;
	plans: PricingPlanInterface[];
}

export const PricingPlans: React.FC<PricingPlansInterface> = ({
	title,
	description,
	plans,
}) => {
	const { t } = useTranslation();

	const [activeInterval, setActiveInterval] =
		useState<PricingPlansContextInterface["activeInterval"]>("yearly");

	return (
		<PricingPlansContext.Provider value={{ activeInterval }}>
			<Panel
				withPadding={false}
				title={title}
				description={description}
				actions={
					<ToggleField
						className="px-2"
						name="yearly"
						leftLabel={t("Monthly")}
						rightLabel={t("Yearly")}
						value={activeInterval === "yearly"}
						setData={(_, value) =>
							setActiveInterval(value ? "yearly" : "monthly")
						}
					/>
				}
				contentClassName="grid grid-cols-2 divide-x divide-gray-200"
			>
				{plans.map((plan, index) => (
					<PricingPlan key={index} {...plan} />
				))}
			</Panel>
		</PricingPlansContext.Provider>
	);
};
