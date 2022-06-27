import React, { ReactElement } from "react";
import { ButtonActions } from "../../ButtonActions";
import IsInsidePanelActionsContext from "../../RenderNode/Nodes/Table/IsInsidePanelActionsContext";

interface PanelHeaderInterface {
	title: string | null;
	description: string | null;
	actions?: ReactElement | null;
	className?: string;
}

export const PanelHeader: React.FC<PanelHeaderInterface> = ({
	title,
	description,
	actions,
	className,
	children,
}) => {
	const hasHeader = title !== null || description !== null;

	if (!hasHeader) {
		return <></>;
	}

	return (
		<div
			className={`flex items-center border-b border-gray-200 ${
				className ?? ""
			}`}
		>
			<div className="flex-1 px-4 py-4 sm:space-y-1 sm:px-6 sm:py-5">
				{title !== null && (
					<h3 className="text-lg font-medium leading-6 text-gray-900">
						{title}
					</h3>
				)}
				{description !== null && (
					<p className="text-sm text-gray-500">{description}</p>
				)}
			</div>

			{actions !== null && (
				<IsInsidePanelActionsContext.Provider value={true}>
					<ButtonActions className="panel-actions">
						{actions}

						{/**
						 * This div in combination with class "panel-actions"
						 * is used to detect if any actions are shown,
						 * and if shown, then css adds padding to it so that
						 * there would be padding on the right side of actions.
						 */}
						<div />
					</ButtonActions>
				</IsInsidePanelActionsContext.Provider>
			)}

			{children}
		</div>
	);
};
