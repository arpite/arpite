import React, { useEffect } from "react";
import { Navigation } from "./partials/Navigation";
import { LayoutCommonInterface } from "../../LayoutCommonInterface";
import { RegularTabsMenu } from "../../Features/Tabs/RegularTabsMenu";
import { SideTabsMenu } from "../../Features/Tabs/SideTabsMenu";
import { TabsMenuDesign } from "../../Features/Tabs/Enums/TabDesign";

export interface TopSideLayoutInterface extends LayoutCommonInterface {
	nodeType: "TopSideLayout";
}

export const TopSideLayout: React.FC<TopSideLayoutInterface> = ({
	title,
	navigation,
	userNavigation,
	tabs,
	tabsDesign,
	children,
}) => {
	useEffect(() => {
		document.body.classList.add("bg-background");

		return () => {
			document.body.classList.remove("bg-background");
		};
	}, []);

	const hasRegularTabs =
		tabsDesign === TabsMenuDesign.REGULAR && tabs.length > 0;
	const hasSideTabs = tabsDesign === TabsMenuDesign.SIDE && tabs.length > 0;

	return (
		<>
			<Navigation items={navigation} userNavigation={userNavigation} />

			<header className="bg-white pt-6 shadow">
				<div
					className={`mx-auto flex max-w-7xl items-end justify-between space-x-6 px-4 sm:px-6 lg:px-8 ${
						hasRegularTabs ? "pb-1" : "pb-5"
					}`}
				>
					<h1 className="text-3xl font-bold tracking-wide text-gray-800">
						{title}
					</h1>
				</div>

				{hasRegularTabs && (
					<div className="mx-auto w-full max-w-7xl lg:px-2">
						<RegularTabsMenu tabs={tabs} />
					</div>
				)}
			</header>

			<main
				className={`mx-auto max-w-7xl py-6 sm:px-6 lg:px-8 ${
					hasSideTabs ? "flex space-x-6" : "space-y-6"
				}`}
			>
				{hasSideTabs ? (
					<>
						<SideTabsMenu tabs={tabs} />

						<div className="flex-1 space-y-6">{children}</div>
					</>
				) : (
					children
				)}
			</main>
		</>
	);
};
