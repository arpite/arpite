import React, { useEffect, useState } from "react";
import { LayoutCommonInterface } from "../../LayoutCommonInterface";
import { UserNavigation } from "../../Features/UserNavigation";
import { SideBar } from "./partials/SideBar";
import { TabsMenuDesign } from "../../Features/Tabs/Enums/TabDesign";
import { RegularTabsMenu } from "../../Features/Tabs/RegularTabsMenu";
import { SideTabsMenu } from "../../Features/Tabs/SideTabsMenu";
import { useMobileLayout } from "../../../../hooks/useMobileLayout";
import { Transition } from "@headlessui/react";
import { useIsLG } from "../../../../hooks/useIsLG";

export interface LeftSideLayoutInterface extends LayoutCommonInterface {
	nodeType: "LeftSideLayout";
}

export const LeftSideLayout: React.FC<LeftSideLayoutInterface> = ({
	title,
	navigation,
	userNavigation,
	tabs,
	tabsDesign: givenTabsDesign,
	children,
}) => {
	const { isMobileLayout } = useMobileLayout();
	const { isLG } = useIsLG();
	const [sidebarOpen, setSidebarOpen] = useState(
		isMobileLayout ? false : localStorage.getItem("sidebar-open") !== "0"
	);

	const tabsDesign =
		tabs.length === 0
			? null
			: isLG
			? givenTabsDesign
			: TabsMenuDesign.REGULAR;

	const sidebarWidthClassName = "w-72";
	const sidebarClosedMarginClassName = "-ml-72";
	const headerHeightClassName =
		tabsDesign === TabsMenuDesign.REGULAR
			? "h-[5.25rem] sm:h-[6.25rem] md:h-[6.5rem]" // h-16 + h-10
			: "h-14 sm:h-16";

	useEffect(() => {
		document.body.classList.add("bg-background");
	}, []);

	useEffect(() => {
		setSidebarOpen(
			isMobileLayout
				? false
				: localStorage.getItem("sidebar-open") !== "0"
		);
		toggleScrollbars(true);
	}, [isMobileLayout]);

	const toggleSidebar = (open: boolean) => {
		if (isMobileLayout) {
			toggleScrollbars(!open);
		} else {
			localStorage.setItem("sidebar-open", open ? "1" : "0");
		}

		setSidebarOpen(open);
	};

	const toggleScrollbars = (show: boolean) => {
		const html = document.querySelector("html");
		if (html !== null) {
			html.classList.toggle("sidebar-hide-scrollbar", !show);
		}
		document.body.classList.toggle("sidebar-hide-scrollbar", !show);
	};

	return (
		<div className="flex">
			<SideBar
				open={sidebarOpen}
				navigation={navigation}
				isMobileLayout={isMobileLayout}
				sideBarWidthClassName={sidebarWidthClassName}
				sideBarClosedMarginClassName={sidebarClosedMarginClassName}
				closeSidebar={() => toggleSidebar(false)}
			/>

			<Transition
				show={isMobileLayout && sidebarOpen}
				enter="transition-opacity duration-300"
				enterFrom="opacity-0"
				enterTo="opacity-100"
				leave="transition-opacity duration-300"
				leaveFrom="opacity-100"
				leaveTo="opacity-0"
				as="div"
				className="fixed inset-0 z-20 cursor-pointer bg-gray-500 bg-opacity-75"
				onClick={() => toggleSidebar(false)}
			/>

			<div className="w-0 flex-1">
				<header
					className={`fixed inset-x-0 z-[9] flex w-full bg-white shadow ${headerHeightClassName}`}
				>
					<div
						className={`transition-width flex-none duration-300 ${
							sidebarOpen && !isMobileLayout
								? sidebarWidthClassName
								: "w-0"
						}`}
					/>

					<div className="w-full flex-1">
						<div className="-ml-2 flex h-14 items-center pl-5 pr-2 sm:h-16 sm:pl-6 sm:pr-4">
							<div className="flex items-center space-x-2 sm:space-x-3">
								<button
									type="button"
									className="h-9 w-9 flex-none space-y-[3px] rounded-full p-2 transition duration-150 hover:bg-background"
									onClick={() => toggleSidebar(!sidebarOpen)}
								>
									<div className="h-[2px] rounded bg-gray-800" />
									<div className="h-[2px] rounded bg-gray-800" />
									<div className="h-[2px] rounded bg-gray-800" />
								</button>

								{title !== null && (
									<h1 className="flex-none text-lg font-medium text-gray-800 sm:text-xl">
										{title}
									</h1>
								)}
							</div>

							<div className="flex-1" />

							<UserNavigation items={userNavigation} />
						</div>

						{tabsDesign === TabsMenuDesign.REGULAR && (
							<RegularTabsMenu
								tabs={tabs}
								className="-mt-1 md:mt-0"
							/>
						)}
					</div>
				</header>

				<div className={headerHeightClassName} />

				<main
					className={`w-full py-4 lg:p-6 ${
						tabsDesign === TabsMenuDesign.SIDE
							? "flex space-x-4 md:space-x-6"
							: "space-y-4 md:space-y-6"
					}`}
				>
					{tabsDesign === TabsMenuDesign.SIDE ? (
						<>
							<SideTabsMenu tabs={tabs} />

							<div className="w-0 flex-1 space-y-4 md:space-y-6">
								{children}
							</div>
						</>
					) : (
						children
					)}
				</main>
			</div>
		</div>
	);
};
