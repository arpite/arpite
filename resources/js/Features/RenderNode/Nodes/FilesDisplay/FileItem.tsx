import { mdiPaperclip } from "@mdi/js";
import React from "react";
import { Icon } from "../../../Icon";
import { NodeType } from "../../NodeType";
import { RenderNodes } from "../../RenderNodes";

export interface FileItemInterface {
	nodeType: "FileItem";
	title: string | null;
	nodes: NodeType[];
}

export const FileItem: React.FC<FileItemInterface> = ({ title, nodes }) => (
	<div className="flex items-center justify-between py-3 pl-3 pr-4 text-sm">
		<div className="flex w-0 flex-1 items-center">
			<Icon
				icon={mdiPaperclip}
				className="h-5 w-5 flex-none text-gray-400"
			/>
			{title !== null && (
				<span className="ml-2 w-0 flex-1 truncate">{title}</span>
			)}
		</div>

		{nodes.length > 0 && (
			<div className="ml-4 shrink-0 space-x-4">
				<RenderNodes nodes={nodes} />
			</div>
		)}
	</div>
);
