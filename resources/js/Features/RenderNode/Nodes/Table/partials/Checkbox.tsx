import React from "react";

interface CheckboxInterface {
	name: string;
	checked: boolean;
	onChange: (name: string, checked: boolean) => void;
	disabled?: boolean;
}

export const Checkbox: React.FC<CheckboxInterface> = ({
	name,
	checked,
	onChange,
	disabled = false,
}) => {
	return (
		<input
			className="focus:shadow-outline rounded border-gray-300 text-primary-600 shadow-sm transition duration-150 disabled:bg-gray-200"
			type="checkbox"
			name={name}
			disabled={disabled}
			checked={checked}
			onChange={(event) => onChange(name, event.target.checked)}
		/>
	);
};
