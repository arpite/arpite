import React from "react";
import { TextInterface } from "../../RenderNode/Nodes/Text";
import { RenderNode } from "../../RenderNode/RenderNode";

interface ChoiceButtonInterface {
	id: string | null;
	title: string | TextInterface | null;
	description: string | null;
	labelClassName?: string;
}

/* eslint-disable @typescript-eslint/no-explicit-any */
export const ChoiceButton: React.FC<ChoiceButtonInterface> = ({
	id,
	title,
	description,
	labelClassName = "",
	children,
}) => {
	const Tag = id === null ? "div" : "label";

	return (
		<div className={`flex ${description === null ? "items-center" : ""}`}>
			{children}

			{(title !== null || description !== null) && (
				<Tag
					htmlFor={Tag === "label" ? (id as any) : undefined}
					className={`flex flex-col text-sm text-gray-900 ${
						description === null ? "ml-2" : "ml-3"
					} ${labelClassName}`}
				>
					{title !== null && (
						<span className="">
							{typeof title === "string" ? (
								title
							) : (
								<RenderNode {...title} />
							)}
						</span>
					)}
					{description !== null && (
						<span className="text-gray-500">{description}</span>
					)}
				</Tag>
			)}
		</div>
	);
};
