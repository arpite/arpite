import React from "react";
import { generateResponsiveVariable } from "../helpers/generateResponsiveVariables";
import { NodeType } from "../NodeType";
import { ResponsiveValueInterface } from "../RenderNodeInterface";
import { RenderNodes } from "../RenderNodes";

export interface FlexInterface {
	nodeType: "Flex";
	display: ResponsiveValueInterface<string>;
	justifyContent: ResponsiveValueInterface<string> | null;
	alignItems: string | null;
	nodes: NodeType[];
}

export const Flex: React.FC<FlexInterface> = ({
	display,
	justifyContent,
	alignItems,
	nodes,
}) => {
	return (
		<div
			className="responsive-display responsive-justify"
			style={{
				...generateResponsiveVariable("d", display),
				...generateResponsiveVariable("jc", justifyContent),
				alignItems: alignItems ?? undefined,
			}}
		>
			<RenderNodes nodes={nodes} />
		</div>
	);
};
