import React from "react";
import { NotificationItemType } from "./Notifications";

type CreateNotificationFunctionType = (
	title: string,
	description: string
) => void;

interface NotificationsContextInterface {
	createNotification: (notification: NotificationItemType) => void;
	successNotification: CreateNotificationFunctionType;
	dangerNotification: CreateNotificationFunctionType;
}

const NotificationsContext = React.createContext<NotificationsContextInterface>(
	{
		createNotification: () => {},
		successNotification: () => {},
		dangerNotification: () => {},
	}
);

export default NotificationsContext;
