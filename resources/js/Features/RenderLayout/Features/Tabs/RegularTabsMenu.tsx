import React from "react";
import { Link } from "../../../Link";
import { TabsMenuItemInterface } from "../../LayoutCommonInterface";

interface RegularTabsMenuInterface {
	tabs: TabsMenuItemInterface[];
	className?: string;
}

export const RegularTabsMenu: React.FC<RegularTabsMenuInterface> = ({
	tabs,
	className,
}) => (
	<nav
		className={`flex h-8 w-full space-x-4 overflow-x-auto px-4 sm:h-10 sm:space-x-8 sm:px-6 ${className}`}
	>
		{tabs.map(({ active, link, title, count }) => (
			<Link
				key={title}
				className={`relative flex h-full items-center px-1 pb-1 text-sm font-medium transition duration-150 focus:outline-none ${
					active
						? "border-primary-600 text-gray-800"
						: "border-[transparent] text-gray-500 hover:text-gray-700"
				}`}
				link={link}
			>
				{title}

				{count !== null && (
					<div className="ml-2 rounded-md bg-gray-200 bg-opacity-80 px-1 py-[2px] text-xs">
						{count}
					</div>
				)}

				<div
					className={`absolute inset-x-0 bottom-0 h-[2px] rounded-t border-t-2 border-primary-600 transition duration-150 ${
						active ? "opacity-100" : "opacity-0"
					}`}
				/>
			</Link>
		))}
	</nav>
);
