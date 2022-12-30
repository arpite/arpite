import React, { useEffect, useRef, useState } from "react";
import { randomString } from "../../helpers/randomString";
import { FieldInterface } from "./FieldsInterfaces";
import { hasError } from "./helpers/hasError";
import { FieldError } from "./partials/FieldError";
import { FieldLabel } from "./partials/FieldLabel";

export interface TagsFieldInterface extends FieldInterface<string[]> {
	label: string;
}

export const TagsField: React.FC<TagsFieldInterface> = (props) => {
	const {
		name,
		label,
		value,
		placeholder,
		required = true,
		disabled = false,
		explanation,
		setData,
	} = props;

	const charSeparators = [","];
	const keySeparators = ["Enter"];
	const allSeparators = [...charSeparators, ...keySeparators];

	const refInput = useRef<HTMLInputElement>(null);

	const [tags, setTags] = useState(value);

	useEffect(() => {
		if (JSON.stringify(value) !== JSON.stringify(tags)) {
			setData?.(name, tags);
		}
	}, [tags]);

	useEffect(() => {
		if (JSON.stringify(value) !== JSON.stringify(tags)) {
			setTags(value);
		}
	}, [value]);

	const escapeRegExp = (text: string) => {
		return text.replace(/[-[\]{}()*+?.,\\^$|#\s]/g, "\\$&");
	};

	const handleOnKeyUp: React.KeyboardEventHandler<HTMLInputElement> = (
		event
	) => {
		event.stopPropagation();

		const text: string = (event.target as any).value; // TODO: fix this any

		if (text === "" && tags.length && event.key === "Backspace") {
			(event.target as any).value = "";
			setTags((previousTags) => [...previousTags.slice(0, -1)]);
		}

		const newTag = text
			.replace(
				new RegExp(charSeparators.map(escapeRegExp).join("|"), "g"),
				""
			)
			.replace(/\n/g, ".")
			.trim();
		if (allSeparators.includes(event.key)) {
			event.preventDefault();

			const tagIsOnlySeparator = charSeparators.some(
				(separator) => separator === newTag
			);
			if (newTag === "" || tagIsOnlySeparator || tags.includes(newTag)) {
				(event.target as any).value = "";
				return;
			}

			setTags((previousTags) => [...previousTags, newTag]);
			(event.target as any).value = "";
		}
	};

	const remoteTag = (text: string) => {
		setTags((previousTags) => previousTags.filter((tag) => tag !== text));
	};

	const id = useRef(randomString()).current;

	return (
		<div>
			<FieldLabel id={id} explanation={explanation} required={required}>
				{label}
			</FieldLabel>

			<div
				className={`mt-1 flex min-h-[38px] w-full flex-wrap items-center rounded-md border border-gray-300 py-1 pl-2 shadow-sm transition duration-150 ${
					hasError(props)
						? "focus-within:shadow-outline-red border-red-400"
						: "focus-within:shadow-outline border-gray-300"
				} ${disabled ? "bg-gray-100" : "bg-white"}`}
				onClick={() => refInput.current?.focus()}
			>
				{tags.map((tag) => (
					<Tag
						key={tag}
						text={tag}
						remove={remoteTag}
						disabled={disabled}
					/>
				))}

				<input
					key="input"
					className="flex-1 border-0 bg-transparent py-0.5 pl-1 pr-3 text-sm text-gray-900 placeholder-gray-400 focus:ring-0"
					ref={refInput}
					type="text"
					name={name}
					id={id}
					placeholder={placeholder ?? ""}
					disabled={disabled}
					onKeyUp={handleOnKeyUp}
					onKeyDown={(event) => {
						if (keySeparators.includes(event.key)) {
							event.preventDefault();
						}
					}}
				/>
			</div>

			<FieldError {...props} />
		</div>
	);
};

interface TagInterface {
	text: string;
	remove: any;
	disabled?: boolean;
}

export const Tag: React.FC<TagInterface> = ({ text, remove, disabled }) => {
	const handleOnRemove: React.MouseEventHandler<HTMLButtonElement> = (
		event
	) => {
		event.stopPropagation();
		remove(text);
	};

	return (
		<div
			className="my-0.5 mr-1 flex items-stretch space-x-0.5 rounded bg-gray-200 bg-opacity-75 pl-1 text-sm text-gray-900"
			onClick={(event) => event.stopPropagation()}
		>
			<span>{text}</span>

			{!disabled && (
				<button
					type="button"
					className="select-none rounded-r px-0.5 transition duration-150 hover:bg-gray-300"
					onClick={handleOnRemove}
					onMouseDown={(event) => event.preventDefault()}
				>
					&#10005;
				</button>
			)}
		</div>
	);
};
