import React from "react";
import { formatDate, formatTime } from "../../../../helpers/formatDate";

export interface TimelineItemInterface {
	nodeType: "TimelineItem";
	title: string | null;
	description: string | null;
	date: string | null;
}

export const TimelineItem: React.FC<TimelineItemInterface> = ({
	title,
	description,
	date,
}) => {
	return (
		<tr className="text-sm even:bg-gray-50">
			<td className="w-[0.1%] whitespace-nowrap py-4 pl-4 pr-4 text-right md:py-6 md:pl-8 md:pr-6">
				{date !== null && (
					<>
						<div className="font-medium text-gray-800">
							{formatDate(date)}
						</div>
						<div className="text-gray-500">{formatTime(date)}</div>
					</>
				)}
			</td>
			<td className="relative w-[0.1%]">
				<div className="absolute inset-0 mx-auto w-px flex-1 bg-gray-200" />
				<div className="relative rounded-full border border-gray-200 bg-white p-2">
					<div className="h-[13px] w-[13px] rounded-full bg-gray-300" />
				</div>
			</td>
			<td className="space-y-[2px] py-4 pl-4 pr-4 md:py-6 md:pl-6 md:pr-8">
				{title !== null && (
					<div className="font-medium text-gray-800">{title}</div>
				)}
				{description !== null && (
					<p className="text-gray-500">{description}</p>
				)}
			</td>
		</tr>
	);
};
