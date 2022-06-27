import { Page } from "@inertiajs/inertia";

export type AuthorizedPagePropsType<T> = Page<
	{
		user: {
			name: string;
			email: string;
		};
	} & T
>;
