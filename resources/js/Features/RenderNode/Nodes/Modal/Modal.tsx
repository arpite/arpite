import { Dialog, Transition } from "@headlessui/react";
import React, { FormEvent, Fragment, useContext, useState } from "react";
import { PanelHeader } from "../../../Panel/partials/PanelHeader";
import { isNode } from "../../helpers/isNode";
import { NodeType } from "../../NodeType";
import { RenderNodes } from "../../RenderNodes";
import { Form, FormInterface } from "../Form/Form";
import ModalContext from "./ModalContext";
import ModalEventsContext from "./ModalEventsContext";
import { CloseModalButton } from "./partials/CloseModalButton";

export interface ModalInterface {
	nodeType: "Modal";
	title: string | null;
	description: string | null;
	form: FormInterface | null;
	design: "SIDE" | "PAGE";
	nodes: NodeType[];
	open?: boolean;
	setOpen?: (open: boolean) => void;
}

export const Modal: React.FC<ModalInterface> = ({
	title,
	description,
	form,
	nodes,
	design,
	open = false,
	setOpen,
}) => {
	const [loading, setLoading] = useState(false);

	const { onSubmitSuccess } = useContext(ModalEventsContext);

	const forceClose = () => {
		setOpen?.(false);
	};

	const close = () => {
		if (!loading) {
			forceClose();
		}
	};

	const onSuccess: FormInterface["onSuccess"] = async (response) => {
		if (response !== null) {
			await onSubmitSuccess?.(response);
		}

		if (response === null || !isNode(response.data)) {
			forceClose();
		}
	};

	return (
		<Transition.Root show={open} as={Fragment}>
			<Dialog
				className="fixed inset-0 z-10 overflow-hidden"
				static
				onClose={close}
				onSubmit={(event: FormEvent<HTMLDivElement>) =>
					event.stopPropagation()
				}
			>
				<Transition.Child
					as={Fragment}
					enter="duration-300"
					enterFrom="opacity-0"
					enterTo="opacity-100"
					leave="duration-300"
					leaveFrom="opacity-100"
					leaveTo="opacity-0"
				>
					<Dialog.Overlay className="absolute inset-0 bg-gray-500 bg-opacity-75" />
				</Transition.Child>

				<div
					className={`fixed inset-y-0 flex ${
						design === "PAGE"
							? "inset-x-0 mx-auto max-w-7xl lg:my-16 lg:px-6"
							: "right-0 w-screen max-w-md"
					}`}
				>
					<Transition.Child
						as="div"
						className="relative w-full flex-1"
						{...(design === "PAGE"
							? {
									enter: "transform transition ease-out duration-300",
									enterFrom: "opacity-0 scale-95",
									enterTo: "opacity-100 scale-100",
									leave: "transform transition ease-in duration-300",
									leaveFrom: "opacity-100 scale-100",
									leaveTo: "opacity-0 scale-95",
							  }
							: {
									enter: "transform transition ease-in-out duration-300",
									enterFrom: "translate-x-full",
									enterTo: "translate-x-0",
									leave: "transform transition ease-in-out duration-300",
									leaveFrom: "translate-x-0",
									leaveTo: "translate-x-full",
							  })}
					>
						<div
							className={`flex h-full flex-col bg-white shadow-xl ${
								design === "PAGE" ? "lg:rounded-lg" : ""
							}`}
						>
							<ModalContext.Provider
								value={{
									isInsideModal: true,
									closeModal: close,
								}}
							>
								{form === null ? (
									<>
										<PanelHeader
											title={title}
											description={description}
											actions={<CloseModalButton />}
										/>

										<div className="flex-1 overflow-y-auto p-4 sm:p-6">
											<RenderNodes nodes={nodes} />
										</div>
									</>
								) : (
									<Form
										{...form}
										setLoading={setLoading}
										onSuccess={onSuccess}
									/>
								)}
							</ModalContext.Provider>
						</div>
					</Transition.Child>
				</div>
			</Dialog>
		</Transition.Root>
	);
};
