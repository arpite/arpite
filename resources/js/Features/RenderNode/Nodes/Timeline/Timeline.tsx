import React from "react";
import { RenderNodes } from "../../RenderNodes";
import { TimelineItemInterface } from "./TimelineItem";

export interface TimelineInterface {
	nodeType: "Timeline";
	timelineItems: TimelineItemInterface[];
}

export const Timeline: React.FC<TimelineInterface> = ({ timelineItems }) => {
	return (
		<div className="-m-4 sm:-m-6">
			<table className="w-full">
				<tbody>
					<RenderNodes nodes={timelineItems} />
				</tbody>
			</table>
		</div>
	);
};
