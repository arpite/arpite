import React from "react";
import { Logo } from "./Logo";
import { Panel } from "./Panel/Panel";
import { ButtonInterface } from "./RenderNode/Nodes/Button";
import { RenderNode } from "./RenderNode/RenderNode";

export interface ShopConnectionPanelInterface {
	nodeType: "ShopConnectionPanel";
	integrationName: string;
	integrationLogoUrl: string;
	acceptButton: ButtonInterface | null;
	permissions: string[];
	permissionsText: string | null;
}

export const ShopConnectionPanel: React.FC<ShopConnectionPanelInterface> = ({
	integrationName,
	integrationLogoUrl,
	acceptButton,
	permissions,
	permissionsText,
}) => {
	return (
		<Panel padding={10}>
			<div className="mb-8 mt-4 flex items-center space-x-12 sm:mb-12">
				<div className="flex-none">
					<Logo className="h-14 w-14 sm:h-16 sm:w-16" />
				</div>

				<div className="flex flex-1 justify-center">
					<svg
						className="h-auto w-20 sm:w-[101px]"
						xmlns="http://www.w3.org/2000/svg"
						width="101"
						height="43"
						viewBox="0 0 101 43"
						fill="none"
					>
						<g clipPath="url(#clip0)" fill="#D1D5DB">
							<path d="M84.5 7.5v.75-.75zm-73.034-.53a.75.75 0 000 1.06l4.772 4.773a.75.75 0 001.061-1.06L13.057 7.5l4.242-4.243a.75.75 0 10-1.06-1.06L11.465 6.97zM97.5 19l-.735.147L97.5 19zm-13-12.25H11.996v1.5H84.5v-1.5zm8 25.25l.513.547h.001l.002-.002c0-.002.002-.003.005-.005l.016-.016a7.067 7.067 0 00.274-.273c.181-.188.436-.46.736-.809a21.55 21.55 0 002.121-2.931c1.47-2.45 2.82-5.897 2.067-9.658l-1.47.294c.647 3.239-.503 6.292-1.883 8.592a20.046 20.046 0 01-1.972 2.725 17.018 17.018 0 01-.91.977l-.011.01a.017.017 0 01-.002.002L92.5 32zm5.736-13.147c-.725-3.623-2.29-6.654-4.632-8.783-2.35-2.136-5.434-3.32-9.104-3.32v1.5c3.33 0 6.045 1.066 8.095 2.93 2.058 1.87 3.494 4.59 4.17 7.967l1.47-.294zM15.727 36.096v-.75.75zm73.035.471a.75.75 0 00-.001-1.06l-4.777-4.77a.75.75 0 00-1.06 1.062l4.246 4.239-4.239 4.246a.75.75 0 101.062 1.06l4.769-4.777zM2.718 24.607l.735-.148-.735.148zm13.01 12.239l72.504-.059-.001-1.5-72.504.059v1.5zm-8.02-25.243l-.515-.547-.002.002-.005.005-.017.016a9.448 9.448 0 00-.273.274c-.181.187-.436.46-.735.809-.598.696-1.38 1.7-2.12 2.933-1.467 2.451-2.814 5.899-2.059 9.66l1.471-.296c-.65-3.238.498-6.293 1.876-8.594a20.055 20.055 0 011.97-2.726 17.101 17.101 0 01.91-.978l.01-.01.002-.002-.514-.546zM1.981 24.753c.728 3.622 2.294 6.652 4.639 8.78 2.351 2.133 5.437 3.315 9.107 3.312l-.002-1.5c-3.33.003-6.045-1.061-8.097-2.923-2.06-1.87-3.498-4.587-4.176-7.964l-1.47.295z" />
						</g>
						<defs>
							<clipPath id="clip0">
								<path fill="#fff" d="M0 0h101v43H0z" />
							</clipPath>
						</defs>
					</svg>
				</div>

				<div className="flex-none">
					<img
						className="h-14 w-14 flex-none sm:h-16 sm:w-16"
						src={integrationLogoUrl}
						alt={integrationName}
					/>
				</div>
			</div>

			{permissionsText !== null && (
				<p className="mb-6 text-sm sm:text-base">{permissionsText}</p>
			)}

			<ul className="mb-8 space-y-5 sm:mb-12">
				{permissions.map((permission, index) => (
					<li
						key={index}
						className="flex space-x-3 text-sm sm:text-base"
					>
						<svg
							xmlns="http://www.w3.org/2000/svg"
							className="h-6 w-6 shrink-0 rounded-full bg-primary-100 p-1 text-primary-800"
							fill="none"
							viewBox="0 0 24 24"
							stroke="currentColor"
						>
							<path
								strokeLinecap="round"
								strokeLinejoin="round"
								strokeWidth="2"
								d="M5 13l4 4L19 7"
							/>
						</svg>
						<span>
							{permission}
							{index >= permissions.length - 1 ? "." : ";"}
						</span>
					</li>
				))}
			</ul>

			{acceptButton !== null && <RenderNode {...acceptButton} />}
		</Panel>
	);
};
