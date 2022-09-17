import { Listbox, Transition } from "@headlessui/react";
import { mdiCheck, mdiClose, mdiUnfoldMoreHorizontal } from "@mdi/js";
import React, { Fragment, useEffect, useRef, useState } from "react";
import { useTranslation } from "react-i18next";
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

export interface SelectFieldInterface
	extends FieldInterface<OptionValueType | OptionValueType[]> {
	label: string;
	multiple: boolean;
	searchable: boolean;
	options: OptionInterface[];
}

export const SelectField: React.FC<SelectFieldInterface> = (props) => {
	const {
		name,
		label,
		multiple,
		searchable,
		options,
		value,
		placeholder,
		required = false,
		disabled = false,
		explanation,
		setData,
	} = props;

	const { t } = useTranslation();

	const refSearchInput = useRef<HTMLInputElement>(null);

	const [filteredOptions, setFilteredOptions] =
		useState<OptionInterface[]>(options);

	const [selectedOptions, setSelectedOptions] = useState<OptionInterface[]>(
		[]
	);

	const onChange = (value: OptionInterface | OptionInterface[] | null) => {
		if (Array.isArray(value)) {
			setData?.(
				name,
				value.map((value) => value.value)
			);
		} else {
			setData?.(name, value?.value ?? null);
		}
	};

	useEffect(() => {
		if (Array.isArray(value)) {
			setSelectedOptions(
				options.filter((option) => value.includes(option.value))
			);
		} else {
			const selectedOption =
				options.find((option) => option.value === value) ?? null;
			setSelectedOptions(selectedOption === null ? [] : [selectedOption]);
		}
	}, [value]); // TODO: add `options` to here?

	const applySearchQuery = (searchQuery: string) => {
		const formattedSearchQuery = searchQuery
			.toLowerCase()
			.replace(/\s+/g, "")
			.trim();

		if (formattedSearchQuery === "") {
			setFilteredOptions(options);
		}

		setFilteredOptions(
			options.filter(({ label }) =>
				label
					.toLowerCase()
					.replace(/\s+/g, "")
					.includes(formattedSearchQuery)
			)
		);
	};

	const showClearButton =
		!required && !disabled && selectedOptions.length > 0;

	return (
		<div>
			<Listbox
				value={multiple ? selectedOptions : selectedOptions[0] ?? null}
				disabled={disabled}
				multiple={multiple}
				onChange={onChange}
			>
				{({ open }) => (
					<>
						<FieldLabel
							as={Listbox.Label}
							id={null}
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
								{selectedOptions.length === 0 ? (
									<div className="h-5 text-gray-400">
										{placeholder ?? ""}
									</div>
								) : (
									<OptionItem
										label={selectedOptions
											.map((option) => option.label)
											.join("; ")}
									/>
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
												onChange(multiple ? [] : null);
											}
										}}
									/>
								</span>
							</Listbox.Button>

							<Transition
								show={open}
								as={Fragment}
								leave="transition duration-150"
								leaveFrom="opacity-100"
								leaveTo="opacity-0"
								afterEnter={() =>
									refSearchInput.current?.focus()
								}
								afterLeave={() => applySearchQuery("")}
							>
								<Listbox.Options
									static
									className={`absolute z-10 mt-1 w-full rounded-md bg-white text-sm shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none ${
										searchable ? "pb-1" : "py-1"
									}`}
								>
									{searchable && (
										<input
											ref={refSearchInput}
											type="text"
											className="w-full rounded-t-md border border-transparent border-x-transparent border-b-gray-200 text-sm transition duration-150 placeholder:text-gray-400 focus:border-primary-500 focus:border-opacity-50 focus:outline-none focus:ring-0"
											placeholder="Search..."
											onChange={(event) =>
												applySearchQuery(
													event.target.value
												)
											}
										/>
									)}

									{filteredOptions.length === 0 && (
										<div
											className={`relative py-2 px-3 text-gray-600 ${
												searchable ? "mt-1" : ""
											}`}
										>
											{t("No results found")}
										</div>
									)}

									<div className="max-h-52 overflow-auto">
										{filteredOptions.map(
											(option, index) => (
												<Listbox.Option
													key={index}
													className={({
														selected,
														active,
													}) =>
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
																label={
																	option.label
																}
																image={
																	option.image
																}
																selected={
																	selected
																}
															/>

															{selected ? (
																<span className="absolute inset-y-0 right-0 flex items-center pr-4 text-primary-600">
																	<Icon
																		icon={
																			mdiCheck
																		}
																		className="h-5 w-5"
																		aria-hidden="true"
																	/>
																</span>
															) : null}
														</>
													)}
												</Listbox.Option>
											)
										)}
									</div>
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

interface OptionItemInterface extends Pick<OptionInterface, "label" | "image"> {
	selected?: boolean;
}

const OptionItem: React.FC<OptionItemInterface> = ({
	label,
	image,
	selected = false,
}) => {
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
