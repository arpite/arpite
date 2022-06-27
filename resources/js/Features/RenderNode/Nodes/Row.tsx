import React from "react";
import { NodeType } from "../NodeType";
import { RenderNodes } from "../RenderNodes";

export interface RowInterface {
	nodeType: "Row";
	nodes: NodeType[];
	gap: number;
}

export const Row: React.FC<RowInterface> = ({ nodes, gap }) => {
	const getSpaceClassName = (gap: number) => {
		return {
			0: "space-x-0",
			1: "space-x-1",
			2: "space-x-2",
			3: "space-x-3",
			4: "space-x-4",
			5: "space-x-5",
			6: "space-x-6",
		}[gap];
	};

	const spaceClassName = getSpaceClassName(gap);

	return (
		<div className={`flex items-center ${spaceClassName}`}>
			<RenderNodes nodes={nodes} />
		</div>
	);
};
