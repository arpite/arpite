import React from "react";
import { NodeType } from "./NodeType";
import { RenderNode } from "./RenderNode";

interface RenderNodesInterface {
	nodes: NodeType[];
	[name: string]: unknown;
}

export const RenderNodes: React.FC<RenderNodesInterface> = ({
	nodes,
	...props
}) => (
	<>
		{nodes.map((node, index) => (
			<RenderNode key={index} {...node} {...props} />
		))}
	</>
);
