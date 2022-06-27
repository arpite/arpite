import { usePage } from "@inertiajs/inertia-react";
import React, { useEffect } from "react";
import { useTesting } from "../../hooks/useTesting";
import { PagePropsType } from "../../Interfaces/PagePropsType";
import { Notifications } from "../Notifications/Notifications";
import { LayoutCommonInterface } from "./LayoutCommonInterface";

export const Layout: React.FC<LayoutCommonInterface> = ({
	title,
	children,
}) => {
	useTesting();

	const { applicationName } = usePage<PagePropsType>().props;

	useEffect(() => {
		if (title !== null) {
			document.title = `${title} - ${applicationName}`;
		}
	}, [title]);

	return <Notifications>{children}</Notifications>;
};
