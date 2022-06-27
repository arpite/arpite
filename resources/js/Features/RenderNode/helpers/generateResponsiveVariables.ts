import React from "react";
import { ResponsiveValueInterface } from "../RenderNodeInterface";

export const generateResponsiveVariable = <T>(
	baseName: string,
	responsiveValue: ResponsiveValueInterface<T> | null,
	transform?: (value: T) => string | number
) => {
	if (responsiveValue === null) {
		return {};
	}

	return Object.entries(responsiveValue).reduce(
		(previous, [breakpoint, value]) => {
			return {
				...previous,
				[`--${breakpoint}-${baseName}`]:
					transform === undefined ? value : transform(value),
			};
		},
		{}
	) as React.CSSProperties;
};
