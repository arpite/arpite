import { usePage } from "@inertiajs/inertia-react";
import React, { useEffect, useState } from "react";
import { randomString } from "../../helpers/randomString";
import { PagePropsType } from "../../Interfaces/PagePropsType";
import NotificationsContext from "./NotificationsContext";
import { Notification, NotificationInterface } from "./partials/Notification";

interface InternalNotificationItemInterface extends NotificationInterface {
	identifier: string;
}

export type NotificationItemType = Pick<
	NotificationInterface,
	"title" | "description" | "type"
>;

export const Notifications: React.FC = ({ children }) => {
	const {
		props: { notification },
	} = usePage<PagePropsType>();

	const [notifications, setNotifications] = useState<
		InternalNotificationItemInterface[]
	>([]);

	useEffect(() => {
		if (notification !== null) {
			createNotification(notification);
		}
	}, [notification]);

	const createNotification = (notification: NotificationItemType) => {
		const identifier = randomString();

		setNotifications((previousNotifications) => [
			...previousNotifications,
			{
				...notification,
				identifier,
				show: true,
				close: () => hideNotification(identifier),
			},
		]);
	};

	const hideNotification = (identifier: string) => {
		setNotifications((previousNotifications) =>
			previousNotifications.map((notification) => {
				return notification.identifier === identifier
					? { ...notification, show: false }
					: notification;
			})
		);

		setTimeout(() => {
			removeNotification(identifier);
		}, 300 + 50);
	};

	const removeNotification = (identifier: string) => {
		setNotifications((previousNotifications) =>
			previousNotifications.filter(
				(notification) => notification.identifier !== identifier
			)
		);
	};

	return (
		<>
			<NotificationsContext.Provider
				value={{
					createNotification,
					successNotification: (title: string, description: string) =>
						createNotification({
							title,
							description,
							type: "success",
						}),
					dangerNotification: (title: string, description: string) =>
						createNotification({
							title,
							description,
							type: "danger",
						}),
				}}
			>
				{children}
			</NotificationsContext.Provider>

			{notifications.length > 0 && (
				<div className="pointer-events-none fixed bottom-0 right-0 z-10 w-full max-w-md space-y-2 p-4 sm:space-y-4 sm:p-6">
					{notifications.map(({ identifier, ...notification }) => (
						<Notification key={identifier} {...notification} />
					))}
				</div>
			)}
		</>
	);
};
