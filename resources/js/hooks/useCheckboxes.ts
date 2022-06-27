import { useState } from "react";

export const useCheckboxes = (allPossibleValues: (string | null)[]) => {
	const [checkedValues, setCheckedValues] = useState<string[]>([]);
	const [headChecked, setHeadChecked] = useState<boolean>(false);

	const onHeadCheckboxChange = (_: string, checked: boolean) => {
		if (checked) {
			setCheckedValues(
				allPossibleValues.filter((value) => value !== null) as string[]
			);
			setHeadChecked(true);
		} else {
			setCheckedValues([]);
			setHeadChecked(false);
		}
	};

	const onCheckboxChange = (givenValue: string, checked: boolean) => {
		if (checked) {
			const newCheckedValues = [...checkedValues, givenValue];
			setCheckedValues(newCheckedValues);

			if (newCheckedValues.length === allPossibleValues.length) {
				setHeadChecked(true);
			}
		} else {
			setCheckedValues(
				checkedValues.filter((value) => value !== givenValue)
			);
			setHeadChecked(false);
		}
	};

	const isChecked = (value: string | null) => {
		return value !== null && checkedValues.includes(value);
	};

	return {
		checkedValues,
		headChecked,
		isChecked,
		onCheckboxChange,
		onHeadCheckboxChange,
	};
};
