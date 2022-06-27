import { usePage } from "@inertiajs/inertia-react";
import React from "react";
import { PagePropsType } from "../../../Interfaces/PagePropsType";
import { Panel } from "../../Panel/Panel";
import { NodeType } from "../NodeType";
import { ButtonActions } from "../../ButtonActions";
import { RenderNodes } from "../RenderNodes";

export interface BalanceInformationInterface {
	nodeType: "BalanceInformation";
	title: string | null;
	actions: NodeType[];
}

export const BalanceInformation: React.FC<BalanceInformationInterface> = ({
	title,
	actions,
}) => {
	const { balance } = usePage<PagePropsType>().props;

	return (
		<Panel contentClassName="flex justify-between items-center">
			<div className="space-y-2">
				{title !== null && (
					<h3 className="font-medium leading-none text-gray-500">
						{title}
					</h3>
				)}
				<h4 className="text-2xl font-bold leading-none text-gray-900">
					{balance}
				</h4>
			</div>

			<ButtonActions>
				<RenderNodes nodes={actions} />
			</ButtonActions>
		</Panel>
	);
};
