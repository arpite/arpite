import React from "react";
import { generateResponsiveVariable as makeResponsiveVariables } from "../helpers/generateResponsiveVariables";
import { NodeType } from "../NodeType";
import { RenderNode } from "../RenderNode";
import { ResponsiveValueInterface } from "../RenderNodeInterface";

export interface GridInterface {
	nodeType: "Grid";
	nodes: NodeType[];
	gap: number;
	columns: ResponsiveValueInterface<number[]>;
}

export const Grid: React.FC<GridInterface> = ({ nodes, gap, columns }) => {
	const getGapClassName = (gap: number) => {
		return {
			0: "gap-0",
			1: "gap-1",
			2: "gap-2",
			3: "gap-3",
			4: "gap-4",
			5: "gap-5",
			6: "gap-6",
		}[gap];
	};

	const gapClassName = getGapClassName(gap);

	return (
		<div
			className={`grid-node-container grid ${gapClassName}`}
			style={makeResponsiveVariables("gtc", columns, (value) =>
				value.reduce((count, current) => count + current, 0)
			)}
		>
			{nodes.map((node, index) => (
				<div
					key={index}
					className="grid-node-item space-y-6"
					style={makeResponsiveVariables(
						"gc",
						columns,
						(columns) => columns[index]
					)}
				>
					<RenderNode key={index} {...node} />
				</div>
			))}
		</div>
	);
};
