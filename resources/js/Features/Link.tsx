import React, { BaseSyntheticEvent, forwardRef, ReactNode } from "react";
import { InertiaLink, usePage } from "@inertiajs/inertia-react";
import { PagePropsType } from "../Interfaces/PagePropsType";

interface LinkInterface {
	type?: "button" | "submit";
	link?: string | null;
	loading?: boolean;
	disabled?: boolean;
	blank?: boolean;
	preserveScroll?: boolean;
	onClick?: (() => void) | null;
	forceLinkTag?: boolean;
	style?: React.CSSProperties;
	className?: string;
	children?: ReactNode;
}

// eslint-disable-next-line
export const Link = forwardRef<any, LinkInterface>(
	(
		{
			type = "button",
			link = null,
			loading = false,
			disabled = false,
			blank = false,
			preserveScroll = false,
			forceLinkTag = false,
			onClick,
			style = {},
			className = "",
			children,
		},
		ref
	) => {
		const { baseUrl } = usePage<PagePropsType>().props;

		const getTag = () => {
			if (link === null && !forceLinkTag) {
				return "button";
			}

			if (
				blank ||
				(link !== null &&
					(link.startsWith("http://") ||
						link.startsWith("https://")) &&
					!link.startsWith(baseUrl))
			) {
				return "a";
			}

			return InertiaLink;
		};

		const onAuxClick = (
			event: React.MouseEvent<HTMLElement, MouseEvent>
		) => {
			/**
			 * Only for mouse middle button
			 */
			if (event.button === 1) {
				onClick?.();
			}
		};

		const Tag = getTag();

		const preserveScrollProp = {
			...(preserveScroll && Tag === InertiaLink
				? { preserveScroll: true }
				: {}),
		};

		const callOnClick =
			<T extends BaseSyntheticEvent>(
				listenerFunction: (event: T) => void
			) =>
			(event: T) => {
				if (Tag !== "button" && (link === undefined || link === null)) {
					event.preventDefault();
				}

				listenerFunction(event);
			};

		return (
			<Tag
				ref={ref}
				className={`${className} focus:outline-none`}
				style={style}
				onClick={
					onClick === undefined || onClick === null
						? undefined
						: callOnClick<
								| React.KeyboardEvent<unknown>
								| React.MouseEvent<unknown, MouseEvent>
						  >(onClick)
				}
				onAuxClick={
					onClick === undefined || onClick === null
						? undefined
						: callOnClick<
								React.MouseEvent<HTMLElement, MouseEvent>
						  >(onAuxClick)
				}
				disabled={Tag === "button" ? disabled || loading : undefined}
				type={Tag === "button" ? type : undefined}
				// eslint-disable-next-line
				href={Tag === "button" ? undefined : ((link ?? "") as any)}
				target={Tag === "button" || !blank ? undefined : "_blank"}
				{...preserveScrollProp}
			>
				{children}
			</Tag>
		);
	}
);
