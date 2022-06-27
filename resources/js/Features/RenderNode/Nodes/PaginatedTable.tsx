import { InertiaLink } from "@inertiajs/inertia-react";
import { mdiChevronLeft, mdiChevronRight } from "@mdi/js";
import React from "react";
import { useTranslation } from "react-i18next";
import { Icon } from "../../Icon";
import { Link } from "../../Link";
import { Table, TableInterface } from "./Table/Table";

export interface PaginatedTableInterface
	extends Omit<TableInterface, "nodeType"> {
	nodeType: "PaginatedTable";
	total: number | null;
	from: number | null;
	to: number | null;
	links: {
		url: string | null;
		label: string;
		active: boolean;
	}[];
	previousPageUrl: string | null;
	nextPageUrl: string | null;
}

export const PaginatedTable: React.FC<PaginatedTableInterface> = ({
	total,
	from,
	to,
	links,
	previousPageUrl,
	nextPageUrl,
	...props
}) => {
	const { t } = useTranslation();

	const showPaginationButtons =
		nextPageUrl !== null || previousPageUrl !== null;

	const showingResultsText =
		from === null || to === null ? null : (
			<>
				{t("Showing from")} <span className="font-medium">{from}</span>{" "}
				{t("to")} <span className="font-medium">{to}</span> {t("of")}{" "}
				<span className="font-medium">{total}</span>{" "}
				{t("results", { context: "of" })}
			</>
		);

	return (
		<div className="-m-4 sm:-m-6">
			<div className="p-4 sm:p-6">
				<Table {...props} nodeType="Table" />
			</div>

			{props.rows.length > 0 && (
				<div className="items-center justify-between border-t border-gray-200 bg-gray-50 px-4 py-3 sm:px-6">
					<div className="flex flex-1 items-center justify-between sm:hidden">
						{showPaginationButtons && (
							<SequenceButton
								direction="previous"
								link={previousPageUrl}
							>
								{t("Previous", { context: "go_to" })}
							</SequenceButton>
						)}

						{showingResultsText !== null && (
							<p
								className={`text-gray-700 ${
									showPaginationButtons
										? "px-6 text-center text-xs xs:text-sm"
										: "text-sm"
								}`}
							>
								{showingResultsText}
							</p>
						)}

						{showPaginationButtons && (
							<SequenceButton direction="next" link={nextPageUrl}>
								{t("Next", { context: "go_to" })}
							</SequenceButton>
						)}
					</div>

					<div className="hidden space-x-4 sm:flex sm:flex-1 sm:items-center sm:justify-between">
						<div>
							{showingResultsText !== null && (
								<p className="text-sm text-gray-700">
									{showingResultsText}
								</p>
							)}
						</div>

						{showPaginationButtons && (
							<nav
								className="relative z-0 inline-flex -space-x-px rounded-md shadow-sm"
								aria-label="Pagination"
							>
								<SequenceButton
									direction="previous"
									link={previousPageUrl}
								/>

								{links.map(({ label, url, active }, index) => (
									<Link
										key={index}
										className={`relative inline-flex items-center border px-4 py-2 text-sm font-medium ${
											active
												? "z-10 border-primary-500 bg-primary-50 text-primary-600"
												: "border-gray-300 bg-white text-gray-500 hover:bg-gray-50 disabled:cursor-default disabled:bg-gray-50"
										}`}
										aria-current={
											active ? "page" : undefined
										}
										link={url}
										disabled={url === null}
										preserveScroll={true}
									>
										{label}
									</Link>
								))}

								<SequenceButton
									direction="next"
									link={nextPageUrl}
								/>
							</nav>
						)}
					</div>
				</div>
			)}
		</div>
	);
};

interface SequenceButtonInterface {
	direction: "previous" | "next";
	link: string | null;
}

const SequenceButton: React.FC<SequenceButtonInterface> = ({
	direction,
	link,
	children,
}) => {
	const { t } = useTranslation();

	const Tag = link === null ? "span" : InertiaLink;

	const separate = children ? true : false;

	const preserveScrollProp = {
		...(Tag === InertiaLink ? { preserveScroll: true } : {}),
	};

	return (
		<Tag
			className={`relative inline-flex items-center border py-2 text-sm font-medium
			${
				separate
					? "rounded-md px-4 text-sm"
					: `px-2 ${
							direction === "previous"
								? "rounded-l-md"
								: "rounded-r-md"
					  }`
			} ${
				link === null
					? "border-gray-200 bg-gray-50 text-gray-400"
					: `border-gray-300 bg-white hover:bg-gray-50 ${
							separate ? "text-gray-700" : "text-gray-500"
					  }`
			}`}
			// eslint-disable-next-line
			href={Tag === "span" ? null : (link as any)}
			{...preserveScrollProp}
		>
			{separate ? (
				children
			) : (
				<>
					<span className="sr-only">
						{direction === "previous"
							? t("Previous", { context: "go_to" })
							: t("Next", { context: "go_to" })}
					</span>
					<Icon
						className="h-5 w-5"
						icon={
							direction === "previous"
								? mdiChevronLeft
								: mdiChevronRight
						}
						aria-hidden="true"
					/>
				</>
			)}
		</Tag>
	);
};
