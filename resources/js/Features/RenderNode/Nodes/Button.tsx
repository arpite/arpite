import React, { useContext, useRef, useState } from "react";
import {
	Button as ButtonComponent,
	ButtonInterface as ButtonComponentInterface,
} from "../../Button";
import { Icon } from "../../Icon";
import {
	ButtonInstanceInterface,
	ButtonTemplate,
	ButtonTemplateRefInterface,
} from "./partials/ButtonTemplate";
import IsInsidePanelActionsContext from "./Table/IsInsidePanelActionsContext";

export interface ButtonInterface extends ButtonInstanceInterface {
	nodeType: "Button";
	icon: string | null;
	design: ButtonComponentInterface["design"];
	disabled: boolean;
	fullWidth: boolean;
	forceActionResponseType: "REGULAR" | "JSON" | null;
	withData: Record<string, unknown>;
	withoutFrontendValidation: boolean;
	className?: string;
}

export const Button: React.FC<ButtonInterface> = ({
	title,
	type,
	link,
	color,
	icon,
	blank,
	disabled,
	fullWidth,
	design,
	className = "",
	...props
}) => {
	const refButton = useRef<ButtonTemplateRefInterface>(null);

	const [loading, setLoading] = useState(false);

	const isInsidePanelActions = useContext(IsInsidePanelActionsContext);

	const showTitle = title !== "" && title !== null;

	return (
		<ButtonTemplate ref={refButton} onLoading={setLoading} {...props}>
			<ButtonComponent
				className={`${fullWidth ? "w-full" : "w-auto"} ${
					showTitle && !isInsidePanelActions
						? "px-4"
						: `min-w-[2.25rem] px-1 ${
								isInsidePanelActions
									? "sm:min-w-none sm:px-4"
									: ""
						  }`
				} ${className}`}
				contentClassName="space-x-2"
				type={type}
				link={link}
				design={design}
				disabled={disabled}
				loading={loading}
				blank={blank}
				color={color}
				onClick={() => refButton.current?.onClick()}
			>
				{icon !== null && (
					<Icon
						icon={icon}
						className={`h-6 w-6 flex-none ${
							design === "secondary" ||
							design === "secondary-with-border"
								? "text-gray-500"
								: ""
						} ${
							showTitle
								? isInsidePanelActions
									? "sm:-ml-1"
									: "-ml-1"
								: ""
						}`}
					/>
				)}

				{showTitle && (
					<span
						className={
							isInsidePanelActions && icon !== null
								? "hidden sm:block"
								: ""
						}
					>
						{title}
					</span>
				)}
			</ButtonComponent>
		</ButtonTemplate>
	);
};
