import React from "react";

interface PanelFooterInterface {
	className?: string;
}

export const PanelFooter: React.FC<PanelFooterInterface> = ({
	className,
	children,
}) => {
	return (
		<div
			className={`bg-gray-50 px-4 py-3 sm:px-6 lg:rounded-b-md ${className}`}
		>
			{children}
		</div>
	);
};
