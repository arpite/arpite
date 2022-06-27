import { Transition } from "@headlessui/react";
import { mdiAlertOutline, mdiCheck, mdiClose } from "@mdi/js";
import React, { useEffect, useRef } from "react";
import { Icon } from "../../Icon";

export interface NotificationInterface {
	title: string;
	description: string;
	type: "success" | "danger";
	show: boolean;
	close: () => void;
}

export const Notification: React.FC<NotificationInterface> = ({
	title,
	description,
	type,
	show,
	close,
}) => {
	// eslint-disable-next-line
	const timeout = useRef<any | null>(null);

	useEffect(() => {
		restartCloseTimeout();
	}, []);

	const restartCloseTimeout = () => {
		timeout.current = setTimeout(() => {
			close();
		}, 5000);
	};

	const clearCloseTimeout = () => {
		if (timeout.current !== null) {
			clearTimeout(timeout.current);
		}
	};

	return (
		<Transition
			show={show}
			appear
			enter="transition-opacity duration-300"
			enterFrom="opacity-0"
			enterTo="opacity-100"
			leave="transition-opacity duration-300"
			leaveFrom="opacity-100"
			leaveTo="opacity-0"
			as="div"
			className="pointer-events-auto flex w-full rounded-lg border border-gray-200 bg-white p-4 shadow-xl"
			onMouseOver={clearCloseTimeout}
			onMouseOut={restartCloseTimeout}
		>
			<div>
				{type === "success" ? (
					<Icon icon={mdiCheck} className="h-6 w-6 text-green-600" />
				) : (
					<Icon
						icon={mdiAlertOutline}
						className="h-6 w-6 text-red-600"
					/>
				)}
			</div>

			<div className="flex-1 space-y-1 pl-4 pr-6">
				{title !== null && (
					<h3 className="text-sm font-medium leading-6 text-gray-900">
						{title}
					</h3>
				)}
				{description !== null && (
					<p className="text-sm text-gray-500">{description}</p>
				)}
			</div>

			<div>
				<button
					type="button"
					className="focus:shadow-outline rounded-full text-gray-500 transition duration-150 hover:text-gray-700"
					onClick={() => close()}
				>
					<Icon icon={mdiClose} className="h-5 w-5" />
				</button>
			</div>
		</Transition>
	);
};
