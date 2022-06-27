import React from "react";

export interface SplitterInterface {
	nodeType: "Splitter";
	title: string | null;
}

export const Splitter: React.FC<SplitterInterface> = ({ title }) => {
	return (
		<div className="flex items-center">
			<div className="flex-1 border-b border-gray-300" />

			{title !== null && (
				<>
					<div className="px-2 text-sm text-gray-500">{title}</div>
					<div className="flex-1 border-b border-gray-300" />
				</>
			)}
		</div>
	);
};
