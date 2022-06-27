import React from "react";
import { RenderNodes } from "../../RenderNodes";
import { ButtonInterface } from "../Button";

export interface CurrentPricingPlanInterface {
	nodeType: "CurrentPricingPlan";
	title: string | null;
	description: string | null;
	buttons: ButtonInterface[];
}

export const CurrentPricingPlan: React.FC<CurrentPricingPlanInterface> = ({
	title,
	description,
	buttons,
}) => {
	return (
		<div className="flex items-center justify-between p-6">
			<div className="space-y-1">
				{title !== null && (
					<h4 className="text-sm font-semibold uppercase leading-6 tracking-wide text-gray-700">
						{title}
					</h4>
				)}

				{description !== null && (
					<p className="text-sm text-gray-500">
						{description.split("\\n").map((piece, index) => (
							<span key={index}>
								{index > 0 && <br />}
								{piece}
							</span>
						))}
					</p>
				)}
			</div>

			{buttons.length > 0 && (
				<div className="flex items-center space-x-2">
					<RenderNodes nodes={buttons} />
				</div>
			)}
		</div>
	);
};
