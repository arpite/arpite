import React from "react";
import { Panel } from "../../../../Panel/Panel";
import { RenderNodes } from "../../../RenderNodes";
import { CardDesignInterface } from "../Card";

export const CardVerticalDesign: React.FC<CardDesignInterface> = ({
	title,
	description,
	image,
	buttons,
}) => (
	<Panel
		withPadding={false}
		className="h-full"
		contentClassName="h-full flex flex-col"
	>
		{image !== null && (
			<div className="flex justify-center pt-10 pb-4">
				<img
					className="h-16 w-16"
					src={image}
					alt={title ?? undefined}
				/>
			</div>
		)}

		<div className="flex flex-1 flex-col justify-between space-y-8 p-4">
			<div className="space-y-1">
				{title !== null && (
					<h3 className="font-medium text-gray-900">{title}</h3>
				)}
				{description !== null && (
					<p className="text-sm text-gray-500">{description}</p>
				)}
			</div>

			{buttons.length > 0 && (
				<div className="flex space-x-2">
					<RenderNodes className="w-full! flex-1" nodes={buttons} />
				</div>
			)}
		</div>
	</Panel>
);
