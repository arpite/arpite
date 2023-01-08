import React, { useRef } from "react";
import { useTranslation } from "react-i18next";
import NumberFormat, { NumberFormatValues } from "react-number-format";
import { randomString } from "../../helpers/randomString";
import { FieldInterface } from "./FieldsInterfaces";
import { hasError } from "./helpers/hasError";
import { FieldError } from "./partials/FieldError";
import { FieldLabel } from "./partials/FieldLabel";

export interface NumberFieldInterface extends FieldInterface<number | null> {
	label: string;
	autofocus?: boolean;
	decimalScale?: number;
	suffix?: string | null;
	min?: number | null;
	max?: number | null;
}

export const NumberField: React.FC<NumberFieldInterface> = (props) => {
	const {
		name,
		label,
		value = null,
		placeholder = null,
		required = true,
		disabled = false,
		autofocus = false,
		decimalScale = 2,
		suffix = null,
		min = null,
		max = null,
		explanation,
		setData,
	} = props;

	const { t } = useTranslation();

	const id = useRef(randomString()).current;

	const multiplier = Math.pow(10, decimalScale);

	const getValue = (values: NumberFormatValues) => {
		if (values.floatValue === undefined) {
			return null;
		}

		return Math.round(values.floatValue * multiplier);
	};

	const errors = {
		...props.errors,
		...(max !== null && value !== null && value > max
			? {
					[name]: t("Value must not be greater than {{ max }}", {
						max: max / multiplier,
					}),
			  }
			: {}),
		...(min !== null && value !== null && value < min
			? {
					[name]: t("Value must be at least {{ min }}", {
						min: min / multiplier,
					}),
			  }
			: {}),
	};

	return (
		<div>
			<FieldLabel id={id} explanation={explanation} required={required}>
				{label}
			</FieldLabel>

			<NumberFormat
				className={`mt-1 block w-full rounded-md text-sm text-gray-900 placeholder-gray-400 shadow-sm transition duration-150 disabled:bg-gray-100 ${
					hasError({ name, errors })
						? "focus:shadow-outline-red border-red-400"
						: "focus:shadow-outline border-gray-300"
				}`}
				type="text"
				name={name}
				id={id}
				value={value === null ? "" : value / multiplier}
				autoFocus={autofocus}
				placeholder={placeholder ?? undefined}
				disabled={disabled}
				displayType="input"
				thousandSeparator={false}
				suffix={suffix ?? undefined}
				fixedDecimalScale={true}
				decimalMark="."
				allowedDecimalSeparators={[",", "."]}
				decimalScale={decimalScale}
				onValueChange={(values) => setData?.(name, getValue(values))}
			/>

			<FieldError {...props} errors={errors} />
		</div>
	);
};
