import React, { forwardRef, ReactNode } from "react";

interface ButtonActionsInterface {
	className?: string;
	children?: ReactNode;
}

export const ButtonActions = forwardRef<HTMLDivElement, ButtonActionsInterface>(
	({ className = "", children }, ref) => (
		<div ref={ref} className={`flex items-center space-x-2 ${className}`}>
			{children}
		</div>
	)
);
