import { TabsMenuDesignType } from "./Features/Tabs/Enums/TabDesign";
import { UserNavigationItemInterface } from "./Features/UserNavigation";
import { NavigationItemInterface } from "./Layouts/TopSideLayout/partials/Navigation";

export interface LayoutCommonInterface {
	title: string | null;
	navigation: NavigationItemInterface[];
	userNavigation: UserNavigationItemInterface[];
	tabs: TabsMenuItemInterface[];
	tabsDesign: TabsMenuDesignType | null;
}

export interface TabsMenuItemInterface {
	title: string;
	link: string;
	count: string | null;
	icon: string | null;
	active: boolean;
}
