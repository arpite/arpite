import React from "react";
import { ButtonActions } from "../../../../ButtonActions";
import { NavigationItem } from "../../../../NavigationItem";
import { Panel } from "../../../../Panel/Panel";
import { RenderNodes } from "../../../RenderNodes";
import { TabsDesignInterface } from "../Tabs";

export const TabsRegularDesign: React.FC<TabsDesignInterface> = ({
	actions,
	eachNavigationItem,
	eachTabContent,
}) => {
	return (
		<Panel withPadding={false}>
			<div className="flex items-center overflow-x-auto">
				{eachNavigationItem(
					({ title, active, link, count, onClick }) => (
						<NavigationItem
							key={title}
							active={active}
							onClick={onClick}
							link={link ?? undefined}
							className="whitespace-nowrap"
						>
							{title}
							{count !== null && (
								<div className="ml-3 rounded-full bg-gray-100 px-2 py-[2px] text-xs">
									{count}
								</div>
							)}
						</NavigationItem>
					)
				)}

				{actions.length > 0 && (
					<ButtonActions className="flex-1 justify-end px-4">
						<RenderNodes nodes={actions} />
					</ButtonActions>
				)}
			</div>

			<div
				className="border-b border-gray-200"
				style={{ marginTop: "-1px" }}
			/>

			{eachTabContent(({ nodes }) => (
				<div className="p-4 sm:p-6">
					<RenderNodes nodes={nodes} />
				</div>
			))}
		</Panel>
	);
};
