import { Disclosure } from "@headlessui/react";
import { Inertia } from "@inertiajs/inertia";
import { InertiaLink, usePage } from "@inertiajs/inertia-react";
import { mdiClose, mdiMenu } from "@mdi/js";
import React from "react";
import { useTranslation } from "react-i18next";
import { AuthorizedPagePropsType } from "../../../../../Interfaces/AuthorizedPageInterface";
import { Icon } from "../../../../Icon";
import { Logo } from "../../../../Logo";
import { NavigationItem } from "../../../../NavigationItem";
import {
	UserNavigation,
	UserNavigationItemInterface,
} from "../../../Features/UserNavigation";

export interface NavigationItemInterface {
	activeMatch: string;
	route: string;
	title: string | null;
	icon: string | null;
}

interface NavigationInterface {
	items: NavigationItemInterface[];
	userNavigation: UserNavigationItemInterface[];
}

export const Navigation: React.FC<NavigationInterface> = ({
	items,
	userNavigation,
}) => {
	const { t } = useTranslation();

	const {
		props: { user },
		url: currentUrl,
	} = usePage<AuthorizedPagePropsType<unknown>>();

	return (
		<Disclosure as="nav" className="relative bg-white">
			{({ open }) => (
				<>
					<div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
						<div className="flex h-16 items-center justify-between">
							<div className="flex h-full items-center">
								<div className="shrink-0">
									<InertiaLink
										href="/"
										className="flex items-center space-x-4"
									>
										<Logo className="h-8 w-8" />
										<span className="text-lg font-bold text-gray-700">
											Lyra
										</span>
									</InertiaLink>
								</div>
								<div className="ml-10 hidden h-full items-center space-x-2 md:flex">
									{items.map(
										({ activeMatch, route, title }) => (
											<NavigationItem
												key={route}
												active={currentUrl.startsWith(
													activeMatch
												)}
												link={route}
											>
												{title}
											</NavigationItem>
										)
									)}
								</div>
							</div>
							<div className="hidden md:block">
								<div className="ml-4 flex items-center md:ml-6">
									<UserNavigation items={userNavigation} />
								</div>
							</div>
							<div className="-mr-2 flex md:hidden">
								<Disclosure.Button className="focus:shadow-outline inline-flex items-center justify-center rounded-md p-2 text-gray-700 hover:bg-gray-100">
									<span className="sr-only">
										{t("Open main menu")}
									</span>

									{open ? (
										<Icon
											icon={mdiClose}
											className="block h-6 w-6"
										/>
									) : (
										<Icon
											icon={mdiMenu}
											className="block h-6 w-6"
										/>
									)}
								</Disclosure.Button>
							</div>
						</div>
					</div>

					<Disclosure.Panel className="md:hidden">
						<div className="space-y-1 px-2 pt-2 pb-3 sm:px-3">
							{items.map(({ route, title }) => (
								<InertiaLink
									key={route}
									href={route}
									className={`focus:shadow-outline block rounded-md px-3 py-2 text-base font-medium text-gray-800 ${
										currentUrl === route
											? "bg-gray-100"
											: "hover:bg-gray-100"
									}`}
								>
									{title}
								</InertiaLink>
							))}
						</div>
						<div className="border-t border-gray-200 pt-4 pb-3">
							<div className="flex items-center px-5">
								<div>
									<div className="text-normal font-bold text-gray-700">
										{user.name}
									</div>
									<div className="h-[2px]" />
									<div className="text-normal font-normal text-gray-700">
										{user.email}
									</div>
								</div>
							</div>
							<div className="mt-3 space-y-1 px-2">
								<InertiaLink
									href="/account/settings"
									className="focus:shadow-outline block w-full rounded-md px-3 py-2 text-left text-base font-medium text-gray-700 hover:bg-gray-100"
								>
									{t("Settings")}
								</InertiaLink>
								<button
									className="focus:shadow-outline w-full rounded-md px-3 py-2 text-left text-base font-medium text-gray-700 hover:bg-gray-100"
									type="button"
									onClick={() => Inertia.post("/auth/logout")}
								>
									{t("Logout")}
								</button>
							</div>
						</div>
					</Disclosure.Panel>
				</>
			)}
		</Disclosure>
	);
};
