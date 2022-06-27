import React from "react";
import { ButtonActions } from "../../ButtonActions";
import { Icon } from "../../Icon";
import { RenderNodes } from "../RenderNodes";
import { ButtonInterface } from "./Button";

export interface AlertBannerInterface {
	nodeType: "AlertBanner";
	description: string | null;
	buttons: ButtonInterface[];
	icon: string | null;
}

export const AlertBanner: React.FC<AlertBannerInterface> = ({
	description,
	buttons,
	icon,
}) => {
	return (
		<div
			className={`flex w-full items-center justify-between rounded-md bg-white py-3 pr-6 shadow ${
				icon === null ? "pl-6" : "pl-5"
			}`}
		>
			<div className="flex items-center space-x-3">
				{icon !== null && (
					<Icon className="h-6 w-6 text-yellow-600" icon={icon} />
				)}
				<div className="flex-1 space-y-1">
					{description !== null && (
						<p className="text-sm text-yellow-700">{description}</p>
					)}
				</div>
			</div>

			{buttons.length > 0 && (
				<ButtonActions>
					<RenderNodes nodes={buttons} />
				</ButtonActions>
			)}
		</div>
	);
};
