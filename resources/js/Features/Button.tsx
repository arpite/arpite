import React, { forwardRef, ReactNode, useEffect, useState } from "react";
import { LoadingIcon } from "./Icons/LoadingIcon";
import { Link } from "./Link";

export interface ButtonInterface {
	type?: "button" | "submit";
	link?: string | null;
	design?: "primary" | "secondary" | "secondary-with-border" | "ternary";
	color?: "primary" | "red" | "yellow" | "gray";
	loading?: boolean;
	disabled?: boolean;
	silentDisabled?: boolean;
	blank?: boolean;
	onClick?: () => void;
	className?: string;
	contentClassName?: string;
	children?: ReactNode;
}

/* eslint-disable react/prop-types */
export const Button = forwardRef<HTMLButtonElement, ButtonInterface>(
	(
		{
			type = "button",
			link = null,
			design = "primary",
			color = "primary",
			loading: givenLoading = false,
			disabled = false,
			silentDisabled = false,
			blank,
			onClick,
			className = "",
			contentClassName = "",
			children,
		},
		ref
	) => {
		const [timeoutLoadingEnded, setTimeoutLoadingEnded] = useState(true);

		useEffect(() => {
			// Sets minimum loading time
			if (givenLoading && timeoutLoadingEnded) {
				setTimeoutLoadingEnded(false);
				setTimeout(() => setTimeoutLoadingEnded(true), 200);
			}
		}, [givenLoading]);

		const loading = givenLoading || !timeoutLoadingEnded;

		const colorClassName = {
			primary: `bg-primary-600 focus:shadow-outline ${
				loading || silentDisabled
					? ""
					: "hover:bg-primary-700 disabled:bg-gray-400"
			}`,
			red: `bg-red-600 focus:shadow-outline-red ${
				silentDisabled ? "" : "hover:bg-red-700 disabled:bg-red-600"
			}`,
			yellow: `bg-yellow-600 focus:shadow-outline-yellow ${
				silentDisabled
					? ""
					: "hover:bg-yellow-700 disabled:bg-yellow-600"
			}`,
			gray: `bg-gray-500 focus:shadow-outline-gray ${
				silentDisabled ? "" : "hover:bg-gray-600 disabled:bg-gray-500"
			}`,
		}[color];

		const getDesignClassName = () => {
			if (design === "primary") {
				return `text-white ${colorClassName}`;
			}

			if (design === "secondary") {
				return `text-gray-700 bg-gray-100 ${
					silentDisabled
						? ""
						: "hover:bg-gray-200 disabled:bg-gray-100"
				}`;
			}

			if (design === "secondary-with-border") {
				return `bg-white text-gray-700 border border-gray-300 ${
					silentDisabled ? "" : "hover:bg-gray-100 disabled:bg-white"
				}`;
			}

			/**
			 * Ternary design
			 */
			return `bg-white text-gray-700 ${
				silentDisabled ? "" : "hover:bg-gray-100 disabled:bg-white"
			}`;
		};

		// TODO: move icon login from Button node component to here

		return (
			<Link
				ref={ref}
				className={`relative flex min-h-[2.25rem] w-full items-center justify-center rounded-md px-4 py-1 text-sm font-medium transition duration-150 disabled:cursor-default ${
					silentDisabled ? "" : "disabled:opacity-40"
				} ${getDesignClassName()} ${className}`}
				type={type}
				link={link}
				loading={loading}
				disabled={disabled || silentDisabled}
				blank={blank}
				onClick={onClick}
			>
				<div
					className={`flex items-center text-left leading-tight ${
						loading ? "opacity-0" : ""
					} ${contentClassName}`}
				>
					{children}
				</div>

				{loading && (
					<div className="pointer-events-none absolute inset-0 flex items-center justify-center">
						<LoadingIcon className="h-4 w-4 animate-spin" />
					</div>
				)}
			</Link>
		);
	}
);
