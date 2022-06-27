import { Menu, Transition } from "@headlessui/react";
import { Inertia } from "@inertiajs/inertia";
import { InertiaLink, usePage } from "@inertiajs/inertia-react";
import { mdiAccountCircle } from "@mdi/js";
import React, { Fragment } from "react";
import { useTranslation } from "react-i18next";
import { PagePropsType } from "../../../Interfaces/PagePropsType";
import { Icon } from "../../Icon";

export interface UserNavigationItemInterface {
	title: string | null;
	route: string;
}

interface UserNavigationInterface {
	items: UserNavigationItemInterface[];
}

export const UserNavigation: React.FC<UserNavigationInterface> = ({
	items,
}) => {
	const { t } = useTranslation();

	const { user, balance } = usePage<PagePropsType>().props;

	return (
		<Menu as="div" className="relative">
			{({ open }) => (
				<>
					<Menu.Button
						className={`flex items-center space-x-2 rounded-full p-1 transition duration-150 ${
							balance === null
								? "sm:p-1"
								: "sm:rounded-lg sm:py-2 sm:pl-2 sm:pr-3"
						} ${
							open
								? "bg-background"
								: "bg-white hover:bg-background"
						}`}
					>
						<div className="focus:shadow-outline flex max-w-xs items-center text-sm">
							<span className="sr-only">
								{t("Open user menu")}
							</span>

							<Icon
								icon={mdiAccountCircle}
								className="h-7 w-7 text-gray-800"
							/>
						</div>

						{balance !== null && (
							<div className="hidden flex-col text-left font-medium leading-tight text-gray-800 sm:flex">
								<span className="text-[0.60rem] uppercase text-gray-500 text-opacity-70">
									{t("Balance")}
								</span>
								<span className="whitespace-nowrap text-[0.80rem]">
									{balance}
								</span>
							</div>
						)}
					</Menu.Button>

					<Transition
						show={open}
						as={Fragment}
						enter="transition ease-out duration-100"
						enterFrom="opacity-0 scale-95"
						enterTo="opacity-100 scale-100"
						leave="transition ease-in duration-75"
						leaveFrom="opacity-100 scale-100"
						leaveTo="opacity-0 scale-95"
					>
						<Menu.Items
							className="min-w-48 user-navigation-w-max absolute right-0 z-10 mt-2 max-w-[18rem] origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
							static
							as="nav"
						>
							{user !== null && (
								<>
									<div className="flex w-full flex-col px-4 py-2 text-left text-sm text-gray-600">
										<div className="break-words font-bold text-gray-600">
											{user.name}
										</div>
										<div className="break-words">
											{user.email}
										</div>
									</div>

									<div className="my-1 w-full border-b" />

									<div className="flex w-full justify-between px-4 py-2 text-left text-sm text-gray-600 sm:hidden">
										<span>{t("Balance")}:</span>
										<span>{balance}</span>
									</div>

									<div className="my-1 w-full border-b sm:hidden" />
								</>
							)}

							{items.map(({ title, route }, index) => (
								<Menu.Item key={index}>
									<InertiaLink
										className="block w-full px-4 py-2 text-left text-sm font-medium text-gray-700 hover:bg-gray-100"
										href={route}
									>
										{title}
									</InertiaLink>
								</Menu.Item>
							))}

							{user !== null && (
								<Menu.Item>
									<button
										className="w-full px-4 py-2 text-left text-sm font-medium text-gray-700 hover:bg-gray-100"
										type="button"
										onClick={() =>
											Inertia.post("/auth/logout")
										}
									>
										{t("Logout")}
									</button>
								</Menu.Item>
							)}
						</Menu.Items>
					</Transition>
				</>
			)}
		</Menu>
	);
};
