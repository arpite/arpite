import React from "react";
import { Icon } from "../../../../Icon";
import { Link } from "../../../../Link";
import { RenderNodes } from "../../../RenderNodes";
import { TabsDesignInterface } from "../Tabs";

export const TabsSideDesign: React.FC<TabsDesignInterface> = ({
	eachNavigationItem,
	eachTabContent,
}) => {
	return (
		<div className="flex space-x-6">
			<div className="flex w-64 flex-none flex-col space-y-1">
				{eachNavigationItem(
					({ title, icon, link, active, count, onClick }) => (
						<Link
							key={title}
							onClick={onClick}
							link={link}
							className={`group focus:shadow-outline flex items-center space-x-3 rounded-md border-primary-600 p-2 text-sm font-medium transition-all duration-150 focus:relative ${
								active
									? "bg-white text-primary-700 shadow"
									: "text-gray-800 hover:bg-white"
							}`}
						>
							{icon !== null && (
								<Icon
									className={`h-6 w-6 flex-none ${
										active
											? "text-primary-600"
											: "text-gray-400"
									}`}
									icon={icon}
								/>
							)}

							<div className="flex-1">{title}</div>

							{count !== null && (
								<div
									className={`ml-3 rounded-full px-2 py-[2px] text-xs text-gray-800 ${
										active
											? "bg-gray-100"
											: "bg-white group-hover:bg-gray-100"
									}`}
								>
									{count}
								</div>
							)}
						</Link>
					)
				)}
			</div>

			<div className="flex-1">
				{eachTabContent(({ nodes }) => (
					<RenderNodes nodes={nodes} />
				))}
			</div>
		</div>
	);
};
