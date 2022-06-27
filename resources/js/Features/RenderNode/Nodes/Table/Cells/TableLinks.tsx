import React from "react";
import { NodeType } from "../../../NodeType";
import { RenderNodes } from "../../../RenderNodes";

export interface TableLinksInterface {
	nodeType: "TableLinks";
	nodes: NodeType[];
}

export const TableLinks: React.FC<TableLinksInterface> = ({ nodes }) => (
	<div className="space-x-6 whitespace-nowrap py-4">
		<RenderNodes nodes={nodes} />
	</div>
);
