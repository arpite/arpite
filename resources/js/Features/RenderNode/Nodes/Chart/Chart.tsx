import "chart.js/auto";
import React from "react";
import { Bar } from "react-chartjs-2";

interface DataSetInterface {
	label: string;
	data: number[];
	backgroundColor: string;
}

export interface ChartInterface {
	nodeType: "Chart";
	labels: string[];
	dataSets: DataSetInterface[];
	dataType: "NUMBER" | "CURRENCY";
	xAxisLabel: string | null;
	yAxisLabel: string | null;
	stacked: boolean;
	height: number;
}

export const Chart: React.FC<ChartInterface> = ({
	labels,
	dataSets,
	dataType,
	xAxisLabel,
	yAxisLabel,
	stacked,
	height,
}) => {
	return (
		<div className="relative w-full" style={{ height: `${height}px` }}>
			<Bar
				data={{
					labels,
					datasets: dataSets,
				}}
				options={{
					responsive: true,
					maintainAspectRatio: false,
					plugins: {
						legend: { position: "right" },
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
