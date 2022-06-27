import Tippy from "@tippyjs/react";
import React from "react";
import { NodeType } from "../NodeType";
import { RenderNodes } from "../RenderNodes";

export interface TooltipInterface {
	nodeType: "Tooltip";
	content: string | null;
	placement: "left" | "right" | "top" | "bottom";
	nodes: NodeType[];
}

export const Tooltip: React.FC<TooltipInterface> = ({
	content,
	placement,
	nodes,
}) => (
	<Tippy content={content} placement={placement}>
		<div>
			<RenderNodes nodes={nodes} />
		</div>
	</Tippy>
);
