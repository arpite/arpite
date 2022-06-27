import { mdiCheck } from "@mdi/js";
import React, { useContext } from "react";
import { useTranslation } from "react-i18next";
import { Icon } from "../../../Icon";
import { NodeType } from "../../NodeType";
import { RenderNodes } from "../../RenderNodes";
import PricingPlansContext from "./PricingPlansContext";

export interface PricingPlanInterface {
	nodeType: "PricingPlan";
	title: string | null;
	description: string | null;
	features: string[];
	monthlyInterval: PricingPeriodIntervalInterface;
	yearlyInterval: PricingPeriodIntervalInterface;
}

interface PricingPeriodIntervalInterface {
	nodeType: "PricingPlanInterval";
	price: number;
	buttons: NodeType[];
	active: boolean;
}

export const PricingPlan: React.FC<PricingPlanInterface> = ({
	title,
	description,
	features,
	monthlyInterval,
	yearlyInterval,
}) => {
	const { t } = useTranslation();

	const { activeInterval } = useContext(PricingPlansContext);

	const { price, buttons, active } =
		activeInterval === "monthly" ? monthlyInterval : yearlyInterval;

	return (
		<div className="h-full space-y-6 p-6">
			<div className="flex-1 space-y-4">
				<div className="space-y-1">
					{title !== null && (
						<div className="flex items-center space-x-2">
							<h3 className="text-sm font-semibold uppercase leading-6 tracking-wide text-gray-700">
								{title}
							</h3>

							{active && (
								<div className="mb-px rounded-full bg-primary-100 px-2 py-[2px] text-[0.625rem] font-medium tracking-wide text-primary-700">
									ACTIVE
								</div>
							)}
						</div>
					)}
					{description !== null && (
						<p className="text-sm text-gray-500">{description}</p>
					)}
				</div>

				<div className="space-y-2">
					<div className="space-x-1 whitespace-nowrap">
						<span className="text-xl font-semibold text-gray-700">
							{price} EUR
						</span>
						<span className="pb-[3px] text-sm text-gray-600">
							/{t("mo")}
						</span>
					</div>

					{buttons.length > 0 && (
						<div className="flex space-x-2">
							<RenderNodes
								className="w-full! flex-1"
								nodes={buttons}
							/>
						</div>
					)}
				</div>
			</div>

			{features.length > 0 && (
				<div className="space-y-2">
					{features.map((feature, index) => (
						<Feature key={index} title={feature} />
					))}
				</div>
			)}
		</div>
	);
};

interface FeatureInterface {
	title: string;
}

const Feature: React.FC<FeatureInterface> = ({ title }) => {
	return (
		<div className="flex items-start space-x-3 space-y-1">
			<Icon
				className="mt-1 h-5 w-5 flex-none text-primary-500"
				icon={mdiCheck}
			/>
			<span className="text-sm text-gray-600">{title}</span>
		</div>
	);
};
