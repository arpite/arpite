import React, { useRef } from "react";
import { randomString } from "../../helpers/randomString";
import { FieldInterface } from "./FieldsInterfaces";
import { hasError } from "./helpers/hasError";
import { ChoiceButton } from "./partials/ChoiceButton";
import { FieldError } from "./partials/FieldError";
import { FieldLabel } from "./partials/FieldLabel";

type RadioButtonValueType = string | number | boolean;

interface GivenRadioButtonInterface {
	title: string | null;
	description: string | null;
	value: RadioButtonValueType;
}

export interface RadiosFieldInterface
	extends FieldInterface<RadioButtonValueType | null> {
	label: string;
	radios: GivenRadioButtonInterface[];
}

export const RadiosField: React.FC<RadiosFieldInterface> = (props) => {
	const {
		label,
		explanation,
		name,
		value,
		disabled = false,
		radios,
		setData,
	} = props;

	const hasAnyDescription = radios.some(
		(radio) => radio.description !== null
	);
	return (
		<div>
			<FieldLabel
				id={null}
				explanation={explanation}
				required={true}
				className="mb-2"
			>
				{label}
			</FieldLabel>

			<div className={hasAnyDescription ? "space-y-3" : "space-y-2"}>
				{radios.map((radio) => (
					<RadioButton
						key={radio.value.toString()}
						{...radio}
						name={name}
						disabled={disabled}
						checked={radio.value === value}
						itHasError={hasError({ name, errors: props.errors })}
						onSelect={() => setData?.(name, radio.value)}
					/>
				))}
			</div>

			<FieldError {...props} />
		</div>
	);
};

interface RadioButtonInterface extends GivenRadioButtonInterface {
	name: string;
	disabled: boolean;
	checked: boolean;
	itHasError: boolean;
	onSelect: () => void;
}

const RadioButton: React.FC<RadioButtonInterface> = ({
	title,
	description,
	name,
	value,
	checked,
	disabled,
	itHasError,
	onSelect,
}) => {
	const id = useRef(randomString()).current;

	return (
		<ChoiceButton id={id} title={title} description={description}>
			<input
				className={`h-4 w-4 text-primary-600 transition duration-150
				${description === null ? "" : "mt-[2px]"} ${
					itHasError && !checked
						? "focus:shadow-outline-red border-red-400"
						: "focus:shadow-outline border-gray-300"
				}`}
				type="radio"
				name={name}
				id={id}
				checked={checked}
				value={value.toString()}
				disabled={disabled}
				onChange={(event) => {
					const checked = event.target.checked;
					if (checked) {
						onSelect();
					}
				}}
			/>
		</ChoiceButton>
	);
};
