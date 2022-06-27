import { Listbox, Transition } from "@headlessui/react";
import { mdiCheck, mdiClose, mdiUnfoldMoreHorizontal } from "@mdi/js";
import React, { Fragment, useEffect, useRef, useState } from "react";
import { randomString } from "../../helpers/randomString";
import { Icon } from "../Icon";
import { FieldInterface } from "./FieldsInterfaces";
import { hasError } from "./helpers/hasError";
import { FieldError } from "./partials/FieldError";
import { FieldLabel } from "./partials/FieldLabel";

type OptionValueType = string | number | boolean | null;

interface OptionInterface {
	label: string;
	value: OptionValueType;
	image?: string | null;
}

export interface SelectFieldInterface extends FieldInterface<OptionValueType> {
	label: string;
	options: OptionInterface[];
}

export const SelectField: React.FC<SelectFieldInterface> = (props) => {
	const {
		name,
		label,
		options,
		value,
		placeholder,
		required = false,
		disabled = false,
		explanation,
		setData,
	} = props;

	const id = useRef(randomString()).current;

	const [selectedOption, setSelectedOption] =
		useState<OptionInterface | null>(null);

	const onChange = (option: OptionInterface | null) => {
		setSelectedOption(option);
		setData?.(name, option?.value ?? null);
	};

	useEffect(() => {
		if (value !== undefined && value !== null) {
			onChange(options.find((option) => option.value === value) ?? null);
		}
	}, [value]);

	const showClearButton = !required && !disabled && selectedOption !== null;

	return (
		<div>
			<Listbox
				value={selectedOption}
				disabled={disabled}
				onChange={onChange}
			>
				{({ open }) => (
					<>
						<FieldLabel
							as={Listbox.Label}
							id={id}
							explanation={explanation}
							required={required}
						>
							{label}
						</FieldLabel>
						<div className="relative mt-1">
							<Listbox.Button
								disabled={disabled}
								className={`relative w-full rounded-md border border-gray-300 bg-white py-2 pl-3 pr-10 text-left text-sm text-gray-900 shadow-sm transition duration-150 disabled:bg-gray-100 ${
									hasError(props)
										? "focus:shadow-outline-red border-red-400"
										: "focus:shadow-outline border-gray-300"
								}`}
							>
								{selectedOption === null ? (
									<div className="h-5 text-gray-400">
										{placeholder ?? ""}
									</div>
								) : (
									<OptionItem option={selectedOption} />
								)}

								<span
									className={`absolute inset-y-0 right-0 ml-3 flex items-center pr-2 ${
										showClearButton
											? ""
											: "pointer-events-none"
									}`}
								>
									<Icon
										icon={
											showClearButton
												? mdiClose
												: mdiUnfoldMoreHorizontal
										}
										className={`h-5 w-5 text-gray-400 ${
											showClearButton
												? "cursor-pointer transition duration-150 hover:text-gray-500"
												: ""
										}`}
										aria-hidden="true"
										onClick={(event) => {
											if (showClearButton) {
												event.stopPropagation();
												onChange(null);
											}
										}}
									/>
								</span>
							</Listbox.Button>

							<Transition
								show={open}
								as={Fragment}
								leave="transition ease-in duration-100"
								leaveFrom="opacity-100"
								leaveTo="opacity-0"
							>
								<Listbox.Options
									static
									className="absolute z-10 mt-1 max-h-56 w-full overflow-auto rounded-md bg-white py-1 text-sm shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
								>
									{options.map((option, index) => (
										<Listbox.Option
											key={index}
											className={({ selected, active }) =>
												`relative cursor-pointer select-none py-2 pl-3 pr-9 focus:outline-none ${
													selected
														? "bg-gray-100"
														: active
														? "bg-gray-100"
														: "text-gray-900"
												}`
											}
											value={option}
										>
											{({ selected }) => (
												<>
													<OptionItem
														option={option}
														selected={selected}
													/>

													{selected ? (
														<span className="absolute inset-y-0 right-0 flex items-center pr-4 text-primary-600">
															<Icon
																icon={mdiCheck}
																className="h-5 w-5"
																aria-hidden="true"
															/>
														</span>
													) : null}
												</>
											)}
										</Listbox.Option>
									))}
								</Listbox.Options>
							</Transition>
						</div>
					</>
				)}
			</Listbox>

			<FieldError {...props} />
		</div>
	);
};

interface OptionItemInterface {
	option: OptionInterface;
	selected?: boolean;
}

const OptionItem: React.FC<OptionItemInterface> = ({
	option,
	selected = false,
}) => {
	const { label, image } = option;

	return (
		<span className="flex items-center space-x-2">
			{image !== undefined && image !== null && (
				<img src={image} alt={label} className="h-5 w-5 shrink-0" />
			)}
			<span
				className={`block truncate ${
					selected ? "font-semibold" : "font-normal"
				}`}
			>
				{label}
			</span>
		</span>
	);
};
