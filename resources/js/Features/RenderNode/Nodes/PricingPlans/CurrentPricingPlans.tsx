import React from "react";
import { Panel } from "../../../Panel/Panel";
import {
	CurrentPricingPlan,
	CurrentPricingPlanInterface,
} from "./CurrentPricingPlan";

export interface CurrentPricingPlansInterface {
	nodeType: "CurrentPricingPlans";
	title: string | null;
	description: string | null;
	plans: CurrentPricingPlanInterface[];
}

export const CurrentPricingPlans: React.FC<CurrentPricingPlansInterface> = ({
	title,
	description,
	plans,
}) => {
	return (
		<Panel
			title={title}
			description={description}
			contentClassName="!p-0 divide-y divide-gray-200"
		>
			{plans.map((plan, index) => (
				<CurrentPricingPlan key={index} {...plan} />
			))}
		</Panel>
	);
};
