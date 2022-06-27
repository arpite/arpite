import React from "react";
import { Layout } from "./Layout";
import { LayoutCommonInterface } from "./LayoutCommonInterface";
import { CentralLayout } from "./Layouts/CentralLayout/CentralLayout";
import { LayoutType } from "./Layouts/LayoutType";
import { LeftSideLayout } from "./Layouts/LeftSideLayout/LeftSideLayout";
import { TopSideLayout } from "./Layouts/TopSideLayout/TopSideLayout";
import { UnauthorizedLayout } from "./Layouts/UnauthorizedLayout/UnauthorizedLayout";

interface RenderLayoutInterface {
	layout: LayoutType;
	commonProperties: LayoutCommonInterface;
}

export const RenderLayout: React.FC<RenderLayoutInterface> = ({
	layout,
	commonProperties,
	children,
}) => {
	const LayoutComponent = {
		CentralLayout: CentralLayout,
		TopSideLayout: TopSideLayout,
		LeftSideLayout: LeftSideLayout,
		UnauthorizedLayout: UnauthorizedLayout,
	}[layout.nodeType];

	/* eslint-disable @typescript-eslint/no-explicit-any */
	if (LayoutComponent) {
		return (
			<Layout {...commonProperties}>
				<LayoutComponent {...commonProperties} {...(layout as any)}>
					{children}
				</LayoutComponent>
			</Layout>
		);
	}

	console.warn(`Layout "${layout.nodeType}" was not found!`);
	return null;
};
