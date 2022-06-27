export const isNode = (node: unknown) => {
	return (
		typeof node === "object" &&
		node !== null &&
		!Array.isArray(node) &&
		"nodeType" in node
	);
};
