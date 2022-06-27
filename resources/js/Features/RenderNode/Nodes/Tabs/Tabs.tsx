import React, { ReactElement, useRef, useState } from "react";
import { NodeType } from "../../NodeType";
import { TabsRegularDesign } from "./designs/TabsRegularDesign";
import { TabsSideDesign } from "./designs/TabsSideDesign";
import { TabDesign, TabDesignType } from "./Enums/TabDesign";

export interface TabInterface {
	nodeType: "Tab";
	title: string;
	primary: boolean;
	nodes: NodeType[];
	actions: NodeType[];
	icon: string | null;
	count: number | null;
	link: string | null;
}

export interface TabsDesignInterface {
	actions: TabInterface["actions"];
	eachNavigationItem: (
		renderNavigationItem: (data: {
			title: TabInterface["title"];
			icon: TabInterface["icon"];
			count: TabInterface["count"];
			link: TabInterface["link"] | null;
			active: boolean;
			onClick: () => void;
		}) => ReactElement
	) => ReactElement[];
	eachTabContent: (
		renderTabContent: (data: {
			nodes: TabInterface["nodes"];
		}) => ReactElement
	) => (ReactElement | undefined)[];
}

export interface TabsInterface {
	nodeType: "Tabs";
	design: TabDesignType;
	tabs: TabInterface[];
}

export const Tabs: React.FC<TabsInterface> = ({ design, tabs }) => {
	const primaryTabIndex = tabs.findIndex((tab) => tab.primary);
	const [activeIndex, setActiveIndex] = useState<number>(
		primaryTabIndex === -1 ? 0 : primaryTabIndex
	);
	const renderedTabs = useRef<boolean[]>(
		Array(tabs.length).fill(false)
	).current;

	const actions = tabs[activeIndex].actions;

	const eachNavigationItem: TabsDesignInterface["eachNavigationItem"] = (
		renderNavigationItem
	) => {
		return tabs.map((tab, index) =>
			renderNavigationItem({
				title: tab.title,
				count: tab.count,
				icon: tab.icon,
				active: activeIndex === index,
				link: tab.link === null ? null : tab.link,
				onClick: () => onTabClick(index),
			})
		);
	};

	const eachTabContent: TabsDesignInterface["eachTabContent"] = (
		renderTabContent
	) => {
		return tabs.map(({ title, nodes }, index) => {
			if (!renderedTabs[index]) {
				if (activeIndex !== index) {
					return;
				}

				renderedTabs[index] = true;
			}

			return (
				<div
					key={title}
					className={activeIndex === index ? "" : "hidden"}
				>
					{renderTabContent({
						nodes,
					})}
				</div>
			);
		});
	};

	const onTabClick = (index: number) => {
		const tab = tabs[index];
		tabs[primaryTabIndex].link !== null || tab.link !== null
			? () => {}
			: setActiveIndex(index);
	};

	const DesignTag =
		design === TabDesign.SIDE ? TabsSideDesign : TabsRegularDesign;
	return (
		<DesignTag
			actions={actions}
			eachNavigationItem={eachNavigationItem}
			eachTabContent={eachTabContent}
		/>
	);
};
