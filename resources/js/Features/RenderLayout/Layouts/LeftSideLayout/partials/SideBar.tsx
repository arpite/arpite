import { InertiaLink, usePage } from "@inertiajs/inertia-react";
import React from "react";
import { NavigationItem } from "./NavigationItem";
import { LayoutCommonInterface } from "../../../LayoutCommonInterface";
import { PagePropsType } from "../../../../../Interfaces/PagePropsType";
import { useTranslation } from "react-i18next";
import { Logo } from "../../../../Logo";

interface SideBarInterface extends Pick<LayoutCommonInterface, "navigation"> {
	open: boolean;
	isMobileLayout: boolean;
	sideBarWidthClassName: string;
	sideBarClosedMarginClassName: string;
	closeSidebar: () => void;
}

export const SideBar: React.FC<SideBarInterface> = ({
	open,
	navigation,
	isMobileLayout,
	sideBarWidthClassName,
	sideBarClosedMarginClassName,
	closeSidebar,
}) => {
	const { t } = useTranslation();

	const {
		props: { applicationName },
		url: currentUrl,
	} = usePage<PagePropsType>();

	return (
		<div
			className={`transition-margin flex-none duration-300 ${
				isMobileLayout ? "fixed z-30" : "relative"
			} ${sideBarWidthClassName} ${
				open ? "ml-0" : sideBarClosedMarginClassName
			}`}
		>
			<div
				className={`fixed z-10 flex h-screen flex-col bg-gray-900 ${sideBarWidthClassName}`}
			>
				<InertiaLink
					className="flex h-16 flex-none items-center justify-center space-x-3 pl-6 pr-10 text-center text-lg font-semibold uppercase text-white"
					href="/"
					onClick={() => isMobileLayout && closeSidebar()}
				>
					<Logo className="h-6 w-6" />
					<span>{applicationName}</span>
				</InertiaLink>

				<nav className="flex-1 space-y-1 overflow-auto py-2">
					{navigation.map(({ activeMatch, route, title, icon }) => (
						<NavigationItem
							key={route}
							active={currentUrl.startsWith(activeMatch)}
							link={route}
							icon={icon}
							onClick={() => isMobileLayout && closeSidebar()}
						>
							{title}
						</NavigationItem>
					))}
				</nav>

				<footer className="py-2 text-center text-xs text-gray-600">
					{t("© {{ year }} {{ name }}. All rights reserved.", {
						year: new Date().getFullYear(),
						name: applicationName,
					})}
				</footer>
			</div>
		</div>
	);
};
