import { mdiPlus, mdiTrashCanOutline } from "@mdi/js";
import React, { useContext, useRef } from "react";
import { randomString } from "../../../../../helpers/randomString";
import { FieldInterface } from "../../../../Fields/FieldsInterfaces";
import { FieldError } from "../../../../Fields/partials/FieldError";
import { FieldLabel } from "../../../../Fields/partials/FieldLabel";
import { Icon } from "../../../../Icon";
import { NodeType } from "../../../NodeType";
import { RenderNodes } from "../../../RenderNodes";
import FormContext, { FormContextInterface } from "../FormContext";
import { WrapperFieldPropsInterface } from "./partials/FieldWrapper";

type ItemValuesType = Record<string, unknown>;

export interface HasManyFieldInterface
	extends WrapperFieldPropsInterface,
		FieldInterface<ItemValuesType[]> {
	nodeType: "HasManyField";
	label: string;
	addButtonText: string | null;
	template: NodeType[];
	templateDefaultValue: ItemValuesType;
}

export const HasManyField: React.FC<HasManyFieldInterface> = (props) => {
	const {
		label,
		name,
		addButtonText,
		template,
		templateDefaultValue,
		explanation,
	} = props;

	const id = useRef(randomString()).current;
	const { values, errors, setData } = useContext(FormContext);
	// eslint-disable-next-line
	const items: ItemValuesType[] = values[name] as any;

	const addEmptyItem = () => {
		setData?.(name, [...items, { ...templateDefaultValue }]);
	};

	const removeItem = (index: number) => {
		setData?.(
			name,
			items.filter((_, itemIndex) => itemIndex !== index)
		);
	};

	const getItemErrors = (index: number) => {
		if (errors === undefined) {
			return [];
		}

		const names = Object.keys(templateDefaultValue);
		return names.reduce(
			(previous, fieldName) => ({
				...previous,
				[fieldName]: errors[`${name}.${index}.${fieldName}`],
			}),
			{}
		);
	};

	const setItemFieldValue = (
		itemFieldName: string,
		itemFieldValue: unknown,
		index: number
	) => {
		setItemData(
			{
				...items[index],
				[itemFieldName]: itemFieldValue,
			},
			index
		);
	};

	const setItemData = (newItemData: ItemValuesType, index: number) => {
		const newItems = items.map((item, itemIndex) => {
			if (index === itemIndex) {
				return newItemData;
			}

			return item;
		});

		setData?.(name, newItems);
	};

	return (
		<div className="space-y-1">
			<div>
				<FieldLabel id={id} explanation={explanation} required={true}>
					{label}
				</FieldLabel>

				<FieldError position="relative" {...props} />
			</div>

			{items.length > 0 && (
				<div className="space-y-2">
					{items.map((values, index) => (
						<Item
							key={index}
							values={values}
							errors={getItemErrors(index)}
							template={template}
							setData={(itemFieldName, itemFieldValue) =>
								setItemFieldValue(
									itemFieldName,
									itemFieldValue,
									index
								)
							}
							setDataRaw={(getNewItemData) =>
								setItemData(getNewItemData(items[index]), index)
							}
							onRemove={() => removeItem(index)}
						/>
					))}
				</div>
			)}

			{addButtonText !== null && (
				<button
					type="button"
					className="focus:shadow-outline flex items-center rounded pr-1 text-sm font-medium text-primary-600 transition duration-150 hover:text-primary-500"
					onClick={addEmptyItem}
				>
					<Icon icon={mdiPlus} className="mr-[2px] h-5 w-5" />
					<span>{addButtonText}</span>
				</button>
			)}
		</div>
	);
};

interface ItemInterface {
	values: ItemValuesType;
	template: NodeType[];
	errors: FieldInterface<unknown>["errors"];
	setData: (name: string, value: unknown) => void;
	setDataRaw: FormContextInterface["setDataRaw"];
	onRemove: () => void;
}

const Item: React.FC<ItemInterface> = ({
	values,
	errors,
	template,
	setData,
	setDataRaw,
	onRemove,
}) => {
	const formContext = useContext(FormContext);

	return (
		<FormContext.Provider
			value={{
				...formContext,
				values,
				errors,
				setData,
				setDataRaw,
			}}
		>
			<div className="flex items-center space-x-1">
				<div className="flex-1 space-y-4 rounded-md bg-gray-100 bg-opacity-80 p-2">
					<RenderNodes nodes={template} />
				</div>
				<button
					type="button"
					className="focus:shadow-outline flex-none rounded p-1 text-gray-600 transition duration-150 hover:text-red-600"
					onClick={onRemove}
				>
					<Icon icon={mdiTrashCanOutline} className="h-5 w-5" />
				</button>
			</div>
		</FormContext.Provider>
	);
};
