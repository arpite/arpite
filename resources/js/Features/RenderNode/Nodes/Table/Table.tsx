import React, { useContext, useEffect, useState } from "react";
import { useCheckboxes } from "../../../../hooks/useCheckboxes";
import { NoResultsFound } from "../../../NoResultsFound";
import { NodeType } from "../../NodeType";
import PanelContext from "../../../Panel/PanelContext";
import { RenderNode } from "../../RenderNode";
import { EmptyStateInterface } from "../EmptyState";
import { Checkbox } from "./partials/Checkbox";
import { ButtonActions } from "../../../ButtonActions";
import { ButtonInterface } from "../Button";
import { RenderNodes } from "../../RenderNodes";
import { useTranslation } from "react-i18next";

interface TableRowInterface {
	nodeType: "TableRow";
	id: string;
	values: (string | number | NodeType)[];
}

export interface TableInterface {
	nodeType: "Table";
	columns: {
		title: string | null;
		identifier: string;
	}[];
	rows: TableRowInterface[];
	widths: number[];
	asPairTable: boolean;
	emptyState: EmptyStateInterface | null;
	actions: NodeType[];
}

export const Table: React.FC<TableInterface> = ({
	columns,
	rows,
	widths,
	asPairTable,
	emptyState,
	actions,
}) => {
	const { t } = useTranslation();

	const {
		checkedValues,
		headChecked,
		onHeadCheckboxChange,
		isChecked,
		onCheckboxChange,
	} = useCheckboxes(rows.map((row) => row.id));

	const [maxNumberOfColumns, setMaxNumberOfColumns] = useState(0);
	const [headCheckboxDisabled, setHeadCheckboxDisabled] = useState(false);

	const { setHeaderOverlay } = useContext(PanelContext);

	useEffect(() => {
		if (checkedValues.length === 0) {
			setHeaderOverlay(null);
			return;
		}

		const actionButtons = actions.map((action) => {
			if (action.nodeType === "Button") {
				const buttonWithData: ButtonInterface = {
					...action,
					actionData: {
						selectedValues: checkedValues,
					},
				};
				return buttonWithData;
			}
			return action;
		});

		setHeaderOverlay(
			<div className="flex h-full flex-col justify-center space-y-1 sm:flex-row sm:items-center sm:justify-start sm:space-y-0 sm:space-x-6">
				<h3 className="font-medium tabular-nums text-gray-600">
					{checkedValues.length} {t("selected")}
				</h3>

				<ButtonActions>
					<RenderNodes nodes={actionButtons} />
				</ButtonActions>
			</div>
		);
	}, [checkedValues]);

	useEffect(() => {
		setHeadCheckboxDisabled(!rows.some((row) => row.id !== null));

		setMaxNumberOfColumns(
			rows.reduce(
				(previous, row) => Math.max(row.values.length, previous),
				0
			)
		);
	}, [rows]);

	const showCheckboxes = actions.length > 0 && rows.length > 0;

	return (
		<div className="-m-4 overflow-x-auto sm:-m-6">
			<table className="min-w-full divide-y divide-gray-200">
				{columns.length > 0 && (
					<thead className="bg-gray-50">
						<tr>
							{showCheckboxes && (
								<th>
									<div className="-mr-1 flex items-center pl-4 pr-2 sm:pr-0">
										<Checkbox
											name="head"
											checked={headChecked}
											disabled={headCheckboxDisabled}
											onChange={onHeadCheckboxChange}
										/>
									</div>
								</th>
							)}

							{columns.map(({ title, identifier }, index) => (
								<th
									key={identifier}
									scope="col"
									className="whitespace-nowrap px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 sm:px-6"
									style={{
										width:
											widths[index] === undefined
												? undefined
												: `${widths[index]}%`,
									}}
								>
									{title}
								</th>
							))}
						</tr>
					</thead>
				)}
				<tbody
					className={`bg-white ${
						asPairTable ? "" : "divide-y divide-gray-200"
					}`}
				>
					{rows.length === 0 ? (
						<tr key="no-results-found">
							<td colSpan={columns.length}>
								{emptyState === null ? (
									<NoResultsFound className="my-8" />
								) : (
									<RenderNode {...emptyState} />
								)}
							</td>
						</tr>
					) : (
						rows.map((row, rowIndex) => (
							<tr
								key={row.id}
								className={`h-[59px] transition duration-150 ${
									isChecked(row.id)
										? "bg-primary-50 bg-opacity-80"
										: asPairTable && rowIndex % 2 !== 0
										? "bg-gray-50"
										: "bg-white"
								}`}
							>
								{showCheckboxes && (
									<td>
										<div className="-mr-1 flex items-center pl-4 pr-2 sm:pr-0">
											<Checkbox
												name={row.id ?? ""}
												disabled={row.id === null}
												checked={isChecked(row.id)}
												onChange={onCheckboxChange}
											/>
										</div>
									</td>
								)}

								{row.values.map((value, columnIndex) => {
									const colSpan =
										columnIndex >= row.values.length - 1
											? maxNumberOfColumns - columnIndex
											: undefined;

									if (
										value !== null &&
										typeof value !== "string" &&
										typeof value !== "number"
									) {
										return (
											<td
												key={columnIndex}
												colSpan={colSpan}
												className={`px-4 text-sm sm:px-6 ${
													asPairTable &&
													columnIndex === 0
														? "w-1/3"
														: ""
												} ${
													value.nodeType ===
													"TableLinks"
														? "w-[0.1%]"
														: ""
												} ${
													value.nodeType ===
														"FilesDisplay" ||
													value.nodeType ===
														"AddressDisplay"
														? "py-5"
														: ""
												}`}
											>
												<RenderNode
													key={columnIndex}
													{...value}
												/>
											</td>
										);
									}

									return (
										<td
											key={columnIndex}
											colSpan={colSpan}
											className={`whitespace-nowrap px-4 text-sm sm:px-6 ${
												asPairTable && columnIndex === 0
													? "w-1/3 font-medium text-gray-500"
													: "text-gray-900"
											}`}
										>
											{value}
										</td>
									);
								})}
							</tr>
						))
					)}
				</tbody>
			</table>
		</div>
	);
};
