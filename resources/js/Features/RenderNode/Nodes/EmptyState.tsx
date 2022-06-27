import React from "react";
import { RenderNodes } from "../RenderNodes";
import { ButtonInterface } from "./Button";

export interface EmptyStateInterface {
	nodeType: "EmptyState";
	title: string | null;
	description: string | null;
	image: string | null;
	buttons: ButtonInterface[];
	className?: string;
}

export const EmptyState: React.FC<EmptyStateInterface> = ({
	title,
	description,
	image,
	buttons,
	className = "",
	children,
}) => (
	<div
		className={`flex flex-col items-center justify-center space-y-4 px-4 py-6 sm:px-6 sm:py-10 ${className}`}
	>
		{image !== null && (
			<img
				className="h-20 w-20 xs:h-24 xs:w-24"
				src={image}
				alt={title ?? undefined}
			/>
		)}
		{children}

		{(title !== null || description !== null) && (
			<div className="space-y-1 text-center">
				{title !== null && (
					<h3 className="font-medium leading-6 text-gray-900 xs:text-lg">
						{title}
					</h3>
				)}

				{description !== null && (
					<p
						className={`max-w-sm text-sm ${
							title === null ? "text-gray-400" : "text-gray-500"
						}`}
					>
						{description}
					</p>
				)}
			</div>
		)}

		{buttons.length > 0 && (
			<div className="flex space-x-6">
				<RenderNodes nodes={buttons} />
			</div>
		)}
	</div>
);
