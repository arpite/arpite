import React from "react";
import { Link } from "./Link";

interface NavigationItemInterface {
	active?: boolean;
	link?: string;
	className?: string;
	onClick?: () => void;
}

export const NavigationItem: React.FC<NavigationItemInterface> = ({
	active,
	link,
	onClick,
	className,
	children,
}) => {
	return (
		<Link
			className={`relative flex items-center rounded-md py-2 px-5 text-sm font-medium transition duration-150 focus:outline-none ${
				active
					? "bg-background text-gray-800"
					: "text-gray-500 hover:text-gray-700"
			} ${className}`}
			link={link}
			onClick={onClick}
		>
			{children}
		</Link>
	);
};
