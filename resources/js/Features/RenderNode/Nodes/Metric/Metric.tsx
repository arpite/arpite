import React from "react";
import { Icon } from "../../../Icon";
import { Panel } from "../../../Panel/Panel";
import { MetricTrend, MetricTrendType } from "./Enums/MetricTrend";

export interface MetricInterface {
	nodeType: "Metric";
	title: string | null;
	icon: string | null;
	value: string | number | null;
	change: number | null;
	changeText: string | null;
	changeTrend: MetricTrendType;
}

export const Metric: React.FC<MetricInterface> = ({
	title,
	value,
	icon,
	change,
	changeText,
	changeTrend,
}) => {
	const getTrendColor = () => {
		return {
			[MetricTrend.UP]: "text-green-600",
			[MetricTrend.DOWN]: "text-red-600",
			[MetricTrend.NONE]: "text-gray-600",
		}[changeTrend];
	};

	return (
		<Panel
			withPadding={false}
			contentClassName={`flex items-center space-x-4 px-6 ${
				icon === null ? "py-5" : "py-6"
			}`}
		>
			{icon !== null && (
				<div className="rounded-md bg-primary-600 p-3">
					<Icon className="h-8 w-8 text-white" icon={icon} />
				</div>
			)}

			<div className="flex-1 space-y-1">
				<h3 className="text-sm font-medium text-gray-500">{title}</h3>
				<div className="flex items-end space-x-2">
					<span className="whitespace-nowrap text-3xl font-semibold leading-none text-gray-800">
						{value}
					</span>

					{change !== null && (
						<div
							className={`flex items-end pb-px ${getTrendColor()}`}
						>
							{change === 0 ? (
								<svg
									xmlns="http://www.w3.org/2000/svg"
									className="h-5 w-5 flex-none"
									viewBox="0 0 20 20"
									fill="currentColor"
								>
									<path
										fill-rule="evenodd"
										d="M5 10a1 1 0 011-1h8a1 1 0 110 2H6a1 1 0 01-1-1z"
										clip-rule="evenodd"
									/>
								</svg>
							) : (
								<svg
									xmlns="http://www.w3.org/2000/svg"
									className={`h-5 w-5 flex-none ${
										change < 0 ? "rotate-180 transform" : ""
									}`}
									viewBox="0 0 20 20"
									fill="currentColor"
								>
									<path
										d="M5.293 9.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 7.414V15a1 1 0 11-2 0V7.414L6.707 9.707a1 1 0 01-1.414 0z"
										fillRule="evenodd"
										clipRule="evenodd"
									/>
								</svg>
							)}

							<span className="text-sm font-medium leading-none">
								{change > 0 ? "+" : ""}
								{change} %
								{changeText !== null && (
									<>
										{" "}
										<span className="text-xs font-normal text-gray-400">
											{changeText}
										</span>
									</>
								)}
							</span>
						</div>
					)}
				</div>
			</div>
		</Panel>
	);
};
