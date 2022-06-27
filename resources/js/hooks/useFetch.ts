import { Inertia } from "@inertiajs/inertia";
import { usePage } from "@inertiajs/inertia-react";
import { useContext } from "react";
import { useTranslation } from "react-i18next";
import { NotificationItemType } from "../Features/Notifications/Notifications";
import NotificationsContext from "../Features/Notifications/NotificationsContext";
import { PagePropsType } from "../Interfaces/PagePropsType";

interface PostInterface {
	action: string;
	data: Record<string, unknown>;
}

export type ResponseSuccessType<T> = {
	success: true;
	data: T;
	errors: null;
};

type ResponseType<T> =
	| ResponseSuccessType<T>
	| {
			success: false;
			data: null;
			errors: Record<string, string>;
	  };

type ResponseInternalType<T> = ResponseType<T> & {
	notification: NotificationItemType | null;
};

export const useFetch = () => {
	const { t } = useTranslation();

	const { csrfToken } = usePage<PagePropsType>().props;

	const { createNotification, dangerNotification } =
		useContext(NotificationsContext);

	const fetchPost = async <T>({
		action,
		data,
	}: PostInterface): Promise<ResponseType<T>> => {
		try {
			const rawResponse = await fetch(action, {
				method: "post",
				headers: {
					"Content-Type": "application/json;charset=utf-8",
					"X-CSRF-TOKEN": csrfToken,
				},
				body: JSON.stringify(data),
			});

			if (rawResponse.redirected) {
				return await new Promise((resolve) => {
					Inertia.visit(rawResponse.url, {
						onFinish: () =>
							resolve({
								success: false,
								data: null,
								errors: {},
							}),
					});
				});
			}

			const { notification, ...response }: ResponseInternalType<T> =
				await rawResponse.json();

			if (notification !== null) {
				createNotification(notification);
			}

			return response;
		} catch (error) {
			dangerNotification(
				t("Something went wrong!"),
				t("Please try again later.")
			);

			return {
				success: false,
				data: null,
				errors: {},
			};
		}
	};

	return {
		fetchPost,
	};
};
