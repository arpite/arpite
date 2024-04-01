import "chart.js/auto";
import React from "react";
import { Chart as ReactChart } from "react-chartjs-2";

interface BarDataSetInterface {
	label: string;
	data: number[];
	backgroundColor: string;
}

interface LineDataSetInterface {
	type: "line";
	label: string;
	data: number[];
	borderColor: string;
	borderWidth: number;
	pointBackgroundColor: string;
}

export interface ChartInterface {
	nodeType: "Chart";
	labels: string[];
	dataSets: (BarDataSetInterface | LineDataSetInterface)[];
	dataType: "NUMBER" | "CURRENCY";
	xAxisLabel: string | null;
	yAxisLabel: string | null;
	stacked: boolean;
	height: number;
	legendPosition:
		| "left"
		| "top"
		| "right"
		| "bottom"
		| "center"
		| "chartArea"
		| null;
}

export const Chart: React.FC<ChartInterface> = ({
	labels,
	dataSets,
	dataType,
	xAxisLabel,
	yAxisLabel,
	stacked,
	height,
	legendPosition,
}) => {
	return (
		<div
			className={`relative w-full ${
				legendPosition === "right" ? "" : "pr-2"
			}`}
			style={{ height: `${height}px` }}
		>
			<ReactChart
				type="bar"
				data={{
					labels,
					datasets: dataSets,
				}}
				options={{
					responsive: true,
					maintainAspectRatio: false,
					plugins: {
						legend: {
							display: Boolean(legendPosition),
							position: legendPosition ?? undefined,
						},
						tooltip: {
							mode: stacked ? "index" : "nearest",
							callbacks: {
								label(context) {
									const label = context.dataset.label || "";

									const value =
										dataType === "CURRENCY"
											? context.parsed.y.toFixed(2) +
											  " EUR"
											: context.parsed.y;

									return `${label}: ${value}`;
								},
							},
						},
					},
					scales: {
						y: {
							stacked,
							ticks: {
								callback(value) {
									return dataType === "CURRENCY"
										? Number(value).toFixed(2)
										: value;
								},
							},
							title: {
								display: yAxisLabel !== null,
								text: yAxisLabel || "",
								font: {
									weight: "700",
								},
							},
						},
						x: {
							stacked,
							title: {
								display: xAxisLabel !== null,
								text: xAxisLabel || "",
								font: {
									weight: "700",
								},
							},
						},
					},
				}}
			/>
		</div>
	);
};
