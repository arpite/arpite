import { usePage } from "@inertiajs/inertia-react";
import React, { ReactElement } from "react";
import { LayoutCommonInterface } from "../Features/RenderLayout/LayoutCommonInterface";
import { LayoutType } from "../Features/RenderLayout/Layouts/LayoutType";
import { RenderLayout } from "../Features/RenderLayout/RenderLayout";
import { RenderNodes } from "../Features/RenderNode/RenderNodes";
import { PagePropsType } from "../Interfaces/PagePropsType";

const StructuredPage: React.FC = () => {
	const { nodes } = usePage<PagePropsType>().props;

	console.log("nodes", nodes);

	return <RenderNodes nodes={nodes} />;
};

// eslint-disable-next-line
(StructuredPage as any).layout = (
	page: ReactElement<{
		layout: LayoutType;
		layoutProperties: LayoutCommonInterface;
	}>
) => {
	const { layout, layoutProperties } = page.props;

	return (
		<RenderLayout layout={layout} commonProperties={layoutProperties}>
			{page}
		</RenderLayout>
	);
};

export default StructuredPage;
