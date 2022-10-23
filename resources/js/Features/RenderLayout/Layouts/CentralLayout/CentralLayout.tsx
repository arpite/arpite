import React, { useEffect } from "react";
import { Logo } from "../../../Logo";
import { NodeType } from "../../../RenderNode/NodeType";
import { RenderNode } from "../../../RenderNode/RenderNode";
import { LayoutCommonInterface } from "../../LayoutCommonInterface";

export interface CentralLayoutInterface extends LayoutCommonInterface {
	nodeType: "CentralLayout";
	showLogo: boolean;
	subtitle: NodeType | null;
}

export const CentralLayout: React.FC<CentralLayoutInterface> = ({
	title,
	showLogo,
	subtitle,
	children,
}) => {
	useEffect(() => {
		document.body.classList.add("bg-background");

		return () => {
			document.body.classList.remove("bg-background");
		};
	}, []);

	return (
		<main className="flex min-h-screen items-center justify-center bg-gray-50">
			<div className="w-full space-y-8 sm:max-w-md">
				{(showLogo || title !== null || subtitle !== null) && (
					<div>
						{showLogo && (
							<Logo className="mx-auto mb-6 h-16 w-16 text-primary-800" />
						)}

						{title !== null && (
							<h2 className="mb-2 text-center text-3xl font-extrabold text-gray-900">
								{title}
							</h2>
						)}

						{subtitle !== null && (
							<p className="text-center text-sm text-gray-600">
								{/* eslint-disable-next-line */}
								<RenderNode {...(subtitle as any)} />
							</p>
						)}
					</div>
				)}

				{children}
			</div>
		</main>
	);
};
