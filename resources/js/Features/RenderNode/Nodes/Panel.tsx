import React from "react";
import { Panel as PanelComponent } from "../../Panel/Panel";
import { NodeType } from "../NodeType";
import { RenderNodes } from "../RenderNodes";

export interface PanelInterface {
	nodeType: "Panel";
	title: string | null;
	description: string | null;
	nodes: NodeType[];
	actions: NodeType[];
	padding: 0 | 1 | 2 | 3 | 4 | 5 | 6 | 7 | 8 | 9 | 10 | 11 | 12;
}

export const Panel: React.FC<PanelInterface> = ({
	title,
	description,
	nodes,
	actions,
	padding,
}) => {
	return (
		<PanelComponent
			title={title}
			description={description}
			actions={<RenderNodes nodes={actions} />}
			padding={padding}
		>
			<RenderNodes nodes={nodes} />
		</PanelComponent>
	);
};
