import React from "react";

interface IconInterface extends React.SVGProps<SVGSVGElement> {
	icon: string;
	className: string;
}

export const Icon: React.FC<IconInterface> = ({
	icon,
	className,
	...props
}) => {
	const isHtmlGiven = icon.includes("<");
	const iconHtml = isHtmlGiven ? icon : `<path d="${icon}"/>`;

	return (
		<svg
			className={`fill-current ${className}`}
			viewBox={isHtmlGiven ? "0 0 512 512" : "0 0 24 24"}
			{...props}
			dangerouslySetInnerHTML={{ __html: iconHtml }}
		/>
	);
};
