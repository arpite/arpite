import React, { useRef, useState } from "react";
import { Link as LinkComponent } from "../../../Link";
import { generateResponsiveVariable } from "../../helpers/generateResponsiveVariables";
import { ResponsiveValueInterface } from "../../RenderNodeInterface";
import {
	ButtonInstanceInterface,
	ButtonTemplate,
	ButtonTemplateRefInterface,
} from "../partials/ButtonTemplate";

export interface LinkInterface extends ButtonInstanceInterface {
	nodeType: "Link";
	textAlign: ResponsiveValueInterface<string> | null;
}

export const Link: React.FC<LinkInterface> = ({
	textAlign,
	title,
	type,
	link,
	blank,
	color,
	...props
}) => {
	const refButton = useRef<ButtonTemplateRefInterface>(null);

	// TODO: add loading state for Link?
	// eslint-disable-next-line
	const [_, setLoading] = useState(false);

	const colorClassName = {
		primary: "text-primary-600 hover:text-primary-500",
		red: "text-red-500 hover:text-red-400",
		yellow: "text-yellow-700 hover:text-yellow-600",
		gray: "text-gray-600 hover:text-gray-500",
	}[color];

	if (title === null) {
		return <></>;
	}

	return (
		<ButtonTemplate ref={refButton} onLoading={setLoading} {...props}>
			<LinkComponent
				className={`responsive-text-align text-sm font-medium transition duration-150 ${colorClassName}`}
				style={generateResponsiveVariable("ta", textAlign)}
				type={type}
				link={link}
				blank={blank}
				onClick={() => refButton.current?.onClick()}
				/**
				 * We need to force using "a" tag when Link node is used
				 * because we need to support break lines, which "button"
				 * tag does not support.
				 */
				forceLinkTag={type !== "submit"}
			>
				{title}
			</LinkComponent>
		</ButtonTemplate>
	);
};
