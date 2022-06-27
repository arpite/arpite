import React from "react";
import { Icon } from "../../../../Icon";
import { Link } from "../../../../Link";

interface NavigationItemInterface {
	active?: boolean;
	link?: string;
	icon?: string | null;
	className?: string;
	onClick?: () => void;
}

export const NavigationItem: React.FC<NavigationItemInterface> = ({
	active,
	link,
	icon = null,
	onClick,
	className,
	children,
}) => {
	return (
		<Link
			className={`relative flex w-full items-center px-6 py-3 text-sm font-medium tracking-wide transition duration-150 ${
				active
					? "bg-white bg-opacity-5 text-white"
					: "bg-opacity-0 text-gray-300 hover:bg-white hover:bg-opacity-5 hover:text-white"
			} ${className}`}
			link={link}
			onClick={onClick}
		>
			<div
				className={`absolute inset-y-0 left-0 w-[2px] rounded-r border-l-[3px] border-primary-600 transition-all duration-150 ${
					active ? "opacity-100" : "opacity-0"
				}`}
			/>

			{icon !== null && <Icon icon={icon} className="mr-4 h-6 w-6" />}
			{children}
		</Link>
	);
};
