import { Switch } from "@headlessui/react";
import React from "react";
import { FieldInterface } from "./FieldsInterfaces";
import { hasError } from "./helpers/hasError";
import { ChoiceButton } from "./partials/ChoiceButton";
import { FieldError } from "./partials/FieldError";

export interface ToggleFieldInterface extends FieldInterface<boolean> {
	label?: string | null;
	leftLabel?: string | null;
	rightLabel?: string | null;
	description?: string | null;
	className?: string;
}

export const ToggleField: React.FC<ToggleFieldInterface> = (props) => {
	const {
		label = null,
		leftLabel = null,
		rightLabel = null,
		description = null,
		name,
		value = false,
		disabled = false,
		setData,
		className = "",
	} = props;

	const isSwitcher = leftLabel !== null && rightLabel !== null;

	const toggleSwitch = (
		<Switch
			checked={value}
			disabled={disabled}
			onChange={(checked) => setData?.(name, checked)}
			className={`focus:shadow-outline-only-border relative inline-flex h-[24px] w-[44px] shrink-0 rounded-full border-2 transition duration-200 ease-in-out ${
				hasError({ name, errors: props.errors })
					? "border-red-300"
					: "border-transparent"
			} ${disabled ? "cursor-not-allowed" : "cursor-pointer"} ${
				value || isSwitcher
					? `bg-primary-600 ${disabled ? "bg-opacity-40" : ""}`
					: `bg-gray-200 ${disabled ? "bg-opacity-60" : ""}`
			}`}
		>
			<span
				aria-hidden="true"
				className={`pointer-events-none mt-px inline-block h-[18px] w-[18px] transform rounded-full shadow-lg ring-0 transition duration-200 ease-in-out ${
					value ? "translate-x-[21px]" : "translate-x-[1px]"
				} ${disabled ? "bg-gray-50" : "bg-white"}`}
			/>
		</Switch>
	);

	return (
		<div className={className}>
			<ChoiceButton
				id={null}
				title={label}
				description={description}
				labelClassName={description === null ? "" : "mt-[2px]"}
			>
				{isSwitcher ? (
					<div className="flex items-center space-x-3">
						{leftLabel !== null && (
							<button
								type="button"
								className={`text-sm font-medium transition duration-150 ${
									value === true
										? "text-gray-400 hover:text-gray-500"
										: "text-gray-900"
								}`}
								onClick={() => setData?.(name, false)}
							>
								{leftLabel}
							</button>
						)}

						{toggleSwitch}

						{rightLabel !== null && (
							<button
								type="button"
								className={`text-sm font-medium transition duration-150 ${
									value === false
										? "text-gray-400 hover:text-gray-500"
										: "text-gray-900"
								}`}
								onClick={() => setData?.(name, true)}
							>
								{rightLabel}
							</button>
						)}
					</div>
				) : (
					toggleSwitch
				)}
			</ChoiceButton>

			<FieldError {...props} />
		</div>
	);
};
