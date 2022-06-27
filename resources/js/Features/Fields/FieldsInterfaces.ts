export interface FieldInterface<T> {
	name: string;
	value: T;
	errors?: Record<string, string>;
	required?: boolean;
	disabled?: boolean;
	placeholder?: string | null;
	explanation?: string | null;
	setData?: (name: string, value: T) => void;
}
