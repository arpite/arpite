import { Page } from "@inertiajs/inertia";
import { NotificationItemType } from "../Features/Notifications/Notifications";
import { NodeType } from "../Features/RenderNode/NodeType";

export type PagePropsType = Page<PagePropsInterface>;

export interface PagePropsInterface {
	nodes: NodeType[];
	baseUrl: string;
	applicationName: string;
	notification: NotificationItemType | null;
	resetFormIdentifier: string | null;
	csrfToken: string;
	errors: Record<string, string>;
	user: {
		name: string;
		email: string;
	} | null;
	balance: string | null;
}
