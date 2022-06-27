export const TabsMenuDesign = {
	REGULAR: "REGULAR" as const,
	SIDE: "SIDE" as const,
};

export type TabsMenuDesignType = keyof typeof TabsMenuDesign;
