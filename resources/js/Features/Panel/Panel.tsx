import React, { ReactElement, useState } from "react";
import { FadeTransition } from "../FadeTransition";
import { PanelInterface as PanelNodeInterface } from "../RenderNode/Nodes/Panel";
import PanelContext from "./PanelContext";
import { PanelHeader } from "./partials/PanelHeader";

interface PanelInterface {
	title?: string | null;
	description?: string | null;
	actions?: ReactElement | null;
	withPadding?: boolean;
	padding?: PanelNodeInterface["padding"];
	className?: string;
	contentClassName?: string;
}

export const Panel: React.FC<PanelInterface> = ({
	title = null,
	description = null,
	actions = null,
	withPadding = true,
	className = "",
	padding = 6,
	contentClassName = "",
	children,
}) => {
	const [headerOverlay, setHeaderOverlay] = useState<ReactElement | null>(
		null
	);

	const getPaddingClassName = () => {
		return {
			0: "sm:p-0",
			1: "sm:p-1",
			2: "sm:p-2",
			3: "sm:p-3",
			4: "sm:p-4",
			5: "sm:p-5",
			6: "sm:p-6",
			7: "sm:p-7",
			8: "sm:p-8",
			9: "sm:p-9",
			10: "sm:p-10",
			11: "sm:p-11",
			12: "sm:p-12",
		}[padding];
	};

	return (
		/**
		 * TODO: add `lg:overflow-hidden` to force roundness on panel content
		 * 		 when tooltips and select fields are updated to add their absolute
		 * 		 containers using react portal so that they wouldn't get cut off
		 * 		 by overflow hidden.
		 * 		 Also remove classes `?:rounded-md` from other components where
		 * 		 no longer needed after overflow hidden is added. Some of those are:
		 * 		 Panel.tsx (current file), PanelFooter.tsx.
		 */
		<div className={`bg-white shadow lg:rounded-md ${className}`}>
			<PanelHeader
				title={title}
				description={description}
				actions={actions}
				className="relative"
			>
				<FadeTransition
					className="absolute inset-0 bg-white px-4 sm:px-6 lg:rounded-t-md"
					child={headerOverlay}
				/>
			</PanelHeader>

			<div
				className={`${
					withPadding ? `p-4 ${getPaddingClassName()}` : ""
				} ${contentClassName}`}
			>
				<PanelContext.Provider value={{ setHeaderOverlay }}>
					{children}
				</PanelContext.Provider>
			</div>
		</div>
	);
};
