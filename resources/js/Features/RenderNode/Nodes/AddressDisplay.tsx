import React from "react";

export interface AddressDisplayInterface {
	nodeType: "AddressDisplay";
	lines: string[];
}

export const AddressDisplay: React.FC<AddressDisplayInterface> = ({
	lines,
}) => (
	<div className="text-sm">
		{lines.map((line, index) => (
			<div
				key={index}
				className={index === 0 ? "text-gray-900" : "text-gray-500"}
			>
				{line}
			</div>
		))}
	</div>
);
