import React from "react";
import { NodeType } from "../../NodeType";
import { RenderNode } from "../../RenderNode";

export interface FilesDisplayInterface {
	nodeType: "FilesDisplay";
	nodes: NodeType[];
}

export const FilesDisplay: React.FC<FilesDisplayInterface> = ({ nodes }) => (
	<ul className="divide-y divide-gray-200 rounded-md border border-gray-200 bg-white">
		{nodes.map((node, index) => (
			<li key={index}>
				<RenderNode {...node} />
			</li>
		))}
	</ul>
);
