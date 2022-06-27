import { Inertia } from "@inertiajs/inertia";
import React, { forwardRef, useImperativeHandle, useState } from "react";
import { useFetch } from "../../../../hooks/useFetch";
import { NodeType } from "../../NodeType";
import { Alert, AlertInterface } from "../Alert/Alert";
import { Modal, ModalInterface } from "../Modal/Modal";

export interface ButtonTemplateRefInterface {
	onClick: () => void;
}

export interface ButtonInstanceInterface extends ButtonTemplateInterface {
	title: string | null;
	link: string | null;
	blank: boolean;
	type: "button" | "submit";
	color: "primary" | "red" | "yellow" | "gray";
}

interface ButtonTemplateInterface {
	action?: string | null;
	nodesAction?: string | null;
	actionAlert?: AlertInterface | null;
	modal?: ModalInterface | null;
	children?: React.ReactNode;
	actionData?: Record<string, unknown> | null;
}

interface ButtonTemplateFrontendInterface {
	onLoading: (loading: boolean) => void;
}

export const ButtonTemplate = forwardRef<
	ButtonTemplateRefInterface,
	ButtonTemplateInterface & ButtonTemplateFrontendInterface
>(
	(
		{
			action = null,
			nodesAction = null,
			actionAlert: givenActionAlert = null,
			modal: givenModal = null,
			actionData = null,
			onLoading,
			children,
		},
		ref
	) => {
		const { fetchPost } = useFetch();

		const [isOpen, setIsOpen] = useState(false);

		const [fetchedModal, setModal] = useState<ModalInterface | null>(null);
		const [fetchedActionAlert, setActionAlert] =
			useState<AlertInterface | null>(null);

		const modal = givenModal ?? fetchedModal;
		const actionAlert = givenActionAlert ?? fetchedActionAlert;

		const onClick = () => {
			if (givenModal !== null || givenActionAlert !== null) {
				setIsOpen(true);
			}

			if (givenActionAlert === null) {
				tryPostAction();
				tryPostNodesAction();
			}
		};

		const tryPostAction = () => {
			return new Promise<void>((resolve) => {
				if (action === null) {
					resolve();
					return;
				}

				/**
				 * We only want to show loading on this button
				 * if we don't show loading on alert
				 */
				if (actionAlert === null) {
					onLoading(true);
				}

				Inertia.post(action, actionData ?? {}, {
					onFinish() {
						if (actionAlert === null) {
							onLoading(false);
						}
						resolve();
					},
				});
			});
		};

		const tryPostNodesAction = async () => {
			if (nodesAction === null) {
				return;
			}

			onLoading(true);
			const response = await fetchPost<NodeType>({
				action: nodesAction,
				data: actionData ?? {},
			});
			onLoading(false);

			if (response.success) {
				const node = response.data;
				if (node.nodeType === "Modal") {
					setModal(node);
				} else if (node.nodeType === "Alert") {
					setActionAlert(node);
				} else {
					throw new Error(
						`Node "${node.nodeType}" is not supported in Button!`
					);
				}

				setIsOpen(true);
			}
		};

		useImperativeHandle(ref, () => ({
			onClick,
		}));

		return (
			<>
				{children}

				{modal !== null && (
					<Modal open={isOpen} setOpen={setIsOpen} {...modal} />
				)}

				{actionAlert !== null && (
					<Alert
						open={isOpen}
						setOpen={setIsOpen}
						onConfirm={tryPostAction}
						{...actionAlert}
					/>
				)}
			</>
		);
	}
);
