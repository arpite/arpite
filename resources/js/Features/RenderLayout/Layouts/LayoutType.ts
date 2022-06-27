import { CentralLayoutInterface } from "./CentralLayout/CentralLayout";
import { LeftSideLayoutInterface } from "./LeftSideLayout/LeftSideLayout";
import { TopSideLayoutInterface } from "./TopSideLayout/TopSideLayout";
import { UnauthorizedLayoutInterface } from "./UnauthorizedLayout/UnauthorizedLayout";

export type LayoutType =
	| CentralLayoutInterface
	| TopSideLayoutInterface
	| LeftSideLayoutInterface
	| UnauthorizedLayoutInterface;
