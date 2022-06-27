import React from "react";
import { Panel } from "../../../../Panel/Panel";
import { RenderNodes } from "../../../RenderNodes";
import { CardDesignInterface } from "../Card";

export const CardSimpleDesign: React.FC<CardDesignInterface> = ({
	title,
	description,
	image,
	buttons,
}) => (
	<Panel
		className="h-full p-4"
		contentClassName="h-full flex flex-col justify-between space-y-3"
		withPadding={false}
	>
		<div className="flex space-x-4">
			{image !== null && (
				<img
					className="h-10 w-10 flex-none"
					src={image}
					alt={title ?? undefined}
				/>
			)}

			<div className="space-y-1">
				{title !== null && (
					<h3 className="text-sm font-medium text-gray-900">
						{title}
					</h3>
				)}
				{description !== null && (
					<p className="text-sm text-gray-500">{description}</p>
				)}
			</div>
		</div>

		{buttons.length > 0 && (
			<div className="flex justify-end space-x-2">
				<RenderNodes nodes={buttons} />
			</div>
		)}
	</Panel>
);
