import React, { useContext } from "react";
import { FieldInterface as FieldComponentInterface } from "../../../../../Fields/FieldsInterfaces";
import { NodeType } from "../../../../NodeType";
import { RenderNodes } from "../../../../RenderNodes";
import FormContext from "../../FormContext";

/* eslint-disable @typescript-eslint/no-explicit-any */
export interface WrapperFieldPropsInterface {
	dependees: {
		value: any;
		fieldsDefaultValues: Record<string, any>;
		nodes: NodeType[];
	}[];
}

interface FieldWrapperInterface {
	props: WrapperFieldPropsInterface & FieldComponentInterface<any>;
	field: React.FC<any>;
}

export const FieldWrapper: React.FC<FieldWrapperInterface> = ({
	props: { dependees, ...props },
	field: Field,
}) => {
	const { values, errors, setDataRaw } = useContext(FormContext);

	// eslint-disable-next-line
	const fieldValue = values[props.name];

	const getActiveDependees = (value: unknown) =>
		dependees.filter(
			(dependantNodesRule) => dependantNodesRule.value === value
		);

	return (
		<>
			<Field
				{...props}
				value={fieldValue}
				errors={errors}
				setData={(name: string, newValue: any) =>
					setDataRaw?.((previousData) => {
						// eslint-disable-next-line
						let newData = {
							...previousData,
						};

						if (fieldValue !== newValue) {
							/**
							 * Remove old dependees values from form
							 */
							getActiveDependees(fieldValue).map((dependee) => {
								Object.entries(
									dependee.fieldsDefaultValues
								).forEach(([name]) => {
									delete newData[name];
								});
							});

							/**
							 * Add new dependees default values to form
							 */
							getActiveDependees(newValue).map((dependee) => {
								Object.entries(
									dependee.fieldsDefaultValues
								).forEach(([name, dependeeValue]) => {
									newData[name] = dependeeValue;
								});
							});
						}

						newData[name] = newValue;

						return newData;
					})
				}
			/>

			{getActiveDependees(fieldValue).map((dependee, index) => (
				<RenderNodes
					key={`${dependee.value}-${index}`}
					nodes={dependee.nodes}
				/>
			))}
		</>
	);
};
