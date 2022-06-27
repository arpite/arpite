import React from "react";
import { StatusImage, StatusImageType } from "../Enums/StatusImage";

export interface TableCellInterface {
	nodeType: "TableCell";
	title: string | null;
	titleLink: string | null;
	description: string | null;
	descriptionLink: string | null;
	image: string | StatusImageType | null;
}

export const TableCell: React.FC<TableCellInterface> = ({
	title,
	titleLink,
	description,
	descriptionLink,
	image,
}) => {
	const isStatusImage =
		image !== null && Object.keys(StatusImage).includes(image);

	return (
		<div className="flex items-center space-x-3 whitespace-nowrap py-2">
			{image !== null &&
				(isStatusImage ? (
					<StatusBubble status={image as StatusImageType} />
				) : (
					<div className="h-8 w-8 flex-none">
						<img
							className="h-full w-full"
							src={image}
							alt={title ?? undefined}
						/>
					</div>
				))}

			{(title !== null || description !== null) && (
				<div className="flex flex-col items-start">
					{title !== null && (
						<Content
							className="text-sm text-gray-900"
							link={titleLink}
						>
							{title}
						</Content>
					)}

					{description !== null && (
						<Content
							className="text-xs text-gray-500"
							link={descriptionLink}
						>
							{description}
						</Content>
					)}
				</div>
			)}
		</div>
	);
};

interface ContentInterface {
	link: string | null;
	className: string;
}

const Content: React.FC<ContentInterface> = ({ link, className, children }) => {
	if (link === null) {
		return <span className={className}>{children}</span>;
	}

	return (
		<a
			className={`hover:underline ${className}`}
			href={link}
			target="_blank"
			rel="noreferrer"
		>
			{children}
		</a>
	);
};

interface StatusBubbleInterface {
	status: StatusImageType;
}

const StatusBubble: React.FC<StatusBubbleInterface> = ({ status }) => {
	const staticStatuses = {
		[StatusImage.RED]: "ring-red-100 bg-red-400",
		[StatusImage.YELLOW]: "ring-orange-100 bg-orange-400",
		[StatusImage.GREEN]: "ring-emerald-100 bg-emerald-400",
		[StatusImage.GRAY]: "ring-gray-100 bg-gray-400",
		[StatusImage.BLUE]: "ring-blue-100 bg-blue-400",
	};

	const pingStatuses = {
		[StatusImage.PING_RED]: staticStatuses[StatusImage.RED],
		[StatusImage.PING_YELLOW]: staticStatuses[StatusImage.YELLOW],
		[StatusImage.PING_GREEN]: staticStatuses[StatusImage.GREEN],
		[StatusImage.PING_GRAY]: staticStatuses[StatusImage.GRAY],
		[StatusImage.PING_BLUE]: staticStatuses[StatusImage.BLUE],
	};

	const colorClassName = {
		...staticStatuses,
		...pingStatuses,
	}[status];

	return (
		<div className={`h-2 w-2 rounded-full ring-4 ${colorClassName}`}>
			{Object.keys(pingStatuses).includes(status) && (
				<div
					className={`h-full w-full animate-ping rounded-full ${colorClassName}`}
				/>
			)}
		</div>
	);
};
