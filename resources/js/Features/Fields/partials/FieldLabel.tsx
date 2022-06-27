import Tippy from "@tippyjs/react";
import React from "react";
import { useTranslation } from "react-i18next";

export interface FieldLabelInterface {
	id: string | null;
	required: boolean;
	explanation: string | null | undefined;
	as?: React.FC | string;
	className?: string;
}

export const FieldLabel: React.FC<FieldLabelInterface> = ({
	id,
	required,
	explanation = null,
	as = "label",
	className = "",
	children,
}) => {
	const { t } = useTranslation();

	// eslint-disable-next-line
	const Tag = as as any;

	return (
		<div
			className={`flex items-center space-x-[0.40rem] text-sm ${className}`}
		>
			<Tag htmlFor={id} className="text-sm font-medium text-gray-700">
				{children}
			</Tag>

			{explanation !== null && (
				<Tippy content={explanation}>
					<div
						key="content"
						className="rounded-[3px] bg-gray-500 bg-opacity-80 p-[1px]"
					>
						<svg
							className="h-[10px] w-[10px] text-white"
							viewBox="0 0 10 10"
							fill="none"
							xmlns="http://www.w3.org/2000/svg"
						>
							<path
								d="M6 3H4V1H6V3ZM6 9H4V6H3V4H6V9Z"
								fill="currentColor"
							/>
							<path
								d="M6 3H4V1H6V3ZM6 9H4V6H3V4H6V9Z"
								fill="currentColor"
							/>
						</svg>
					</div>
				</Tippy>
			)}

			{required === false && (
				<span className="rounded bg-gray-200 bg-opacity-75 px-[0.32rem] py-[0.20rem] text-xs font-medium leading-none text-gray-600 text-opacity-90">
					{t("Optional")}
				</span>
			)}
		</div>
	);
};
