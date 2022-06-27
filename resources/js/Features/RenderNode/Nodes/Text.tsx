import React from "react";
import { nl2br } from "../../../helpers/nl2br";
import { NodeType } from "../NodeType";
import { RenderNode } from "../RenderNode";

export interface TextInterface {
	nodeType: "Text";
	nodesAndStrings: (string | NodeType)[];
	color: string | null;
}

export const Text: React.FC<TextInterface> = ({ nodesAndStrings, color }) => {
	return (
		<span
			style={{
				color: color ?? undefined,
			}}
		>
			{nodesAndStrings.map((nodeOrString, index) => {
				if (typeof nodeOrString === "string") {
					return nl2br(nodeOrString);
				}

				return <RenderNode key={index} {...nodeOrString} />;
			})}
		</span>
	);
};
