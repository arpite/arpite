import { Transition } from "@headlessui/react";
import { Inertia } from "@inertiajs/inertia";
import { usePage } from "@inertiajs/inertia-react";
import React, {
	FormEvent,
	useContext,
	useEffect,
	useRef,
	useState,
} from "react";
import { randomString } from "../../../../helpers/randomString";
import { ResponseSuccessType, useFetch } from "../../../../hooks/useFetch";
import {
	PagePropsInterface,
	PagePropsType,
} from "../../../../Interfaces/PagePropsType";
import { Panel } from "../../../Panel/Panel";
import { PanelFooter } from "../../../PanelFooter";
import { NodeType } from "../../NodeType";
import { RenderNodes } from "../../RenderNodes";
import ModalContext from "../Modal/ModalContext";
import { CloseModalButton } from "../Modal/partials/CloseModalButton";
import { FormButtonInterface } from "./FormButton";
import FormContext from "./FormContext";

export interface FormInterface {
	nodeType: "Form";
	title: string | null;
	description: string | null;
	actions: NodeType[];
	action: string | null;
	actionResponseType: "REGULAR" | "JSON";
	values: Record<string, unknown>;
	leftButtons: FormButtonInterface[];
	rightButtons: FormButtonInterface[];
	stickyHeader: NodeType[];
	nodes: NodeType[];
	preserveScroll: boolean;
	withPanel: boolean;
	setLoading?: (loading: boolean) => void;
	onSuccess?: <T>(response: ResponseSuccessType<T> | null) => Promise<void>;
}

export interface SubmitOptionsInterface {
	triggerId?: string | null;
	withoutValidation?: boolean;
	actionResponseType?: FormInterface["actionResponseType"] | null;
	withData?: Record<string, unknown>;
}

export const Form: React.FC<FormInterface> = (givenProps) => {
	const props = useRef(givenProps);
	const initialBuild = useRef<boolean>(true);

	const [version, setVersion] = useState(0);

	const rebuild = (formNode: FormInterface) => {
		props.current = { ...givenProps, ...formNode };
		initialBuild.current = false;

		// Important! `setVersion` must be called last.
		setVersion((previousVersion) => previousVersion + 1);
	};

	return (
		<InternalForm
			key={version}
			{...props.current}
			initialBuild={initialBuild.current}
			rebuild={rebuild}
		/>
	);
};

interface InternalFormInterface extends FormInterface {
	initialBuild: boolean;
	rebuild: (formNode: FormInterface) => void;
}

const InternalForm: React.FC<InternalFormInterface> = ({
	initialBuild,
	title,
	description,
	actions,
	action,
	actionResponseType: givenActionResponseType,
	values: givenValues,
	leftButtons,
	rightButtons,
	stickyHeader,
	nodes,
	preserveScroll,
	withPanel,
	setLoading: givenSetLoading,
	onSuccess,
	rebuild,
}) => {
	const formIdentifier = useRef(randomString()).current;
	const refSubmitButton = useRef<HTMLButtonElement>(null);
	const submitPromiseResolve = useRef<((value: void) => void) | null>(null);

	const oneTimeSubmitOptions = useRef<SubmitOptionsInterface>({});

	const { isInsideModal } = useContext(ModalContext);

	const { errors: errorsRegularAction } = usePage<PagePropsType>().props;

	const [submitTriggerId, setSubmitTriggerId] = useState<string | null>(null);
	const [loading, setLoading] = useState(false);
	const [errorsJsonAction, setErrorsJsonAction] = useState<
		Record<string, string>
	>({});

	const { fetchPost } = useFetch();

	const [data, setData] = useState<Record<string, unknown>>(givenValues);

	const errors = { ...errorsJsonAction, ...errorsRegularAction };

	const submit = async () => {
		if (action === null) {
			submitPromiseResolve.current?.();
			return;
		}

		const options = oneTimeSubmitOptions.current;
		setSubmitTriggerId(options.triggerId ?? null);
		const actionResponseType =
			options.actionResponseType ?? givenActionResponseType;
		const submitData = {
			...data,
			...options.withData,
			_formIdentifier: formIdentifier,
		};

		oneTimeSubmitOptions.current = {};

		if (actionResponseType === "REGULAR") {
			setLoading(true);
			Inertia.post(action, submitData, {
				preserveScroll,
				onSuccess(page) {
					const props = page.props as PagePropsInterface;
					if (props.resetFormIdentifier === formIdentifier) {
						setData(givenValues);
					}

					onSuccess?.(null);
				},
				onFinish() {
					submitPromiseResolve.current?.();
					stopLoading();
				},
			});
			return;
		}

		setLoading(true);
		const response = await fetchPost<FormInterface | null>({
			action,
			data: submitData,
		});
		submitPromiseResolve.current?.();

		if (response.success) {
			await onSuccess?.(response);
			stopLoading();

			if (response.data !== null) {
				rebuild(response.data);
			}
			return;
		}

		stopLoading();
		setErrorsJsonAction(response.errors);
	};

	const stopLoading = () => {
		setLoading(false);
		setSubmitTriggerId(null);
	};

	const triggerSubmit = async (options: SubmitOptionsInterface = {}) => {
		return new Promise<void>((resolve) => {
			submitPromiseResolve.current = resolve;
			oneTimeSubmitOptions.current = options;

			if (options.withoutValidation) {
				submit();
			} else {
				refSubmitButton.current?.click();
			}
		});
	};

	useEffect(() => {
		givenSetLoading?.(loading);
	}, [loading]);

	const getContent = () => {
		const className = `flex-1 space-y-6 ${
			withPanel
				? `p-4 sm:p-6 ${isInsideModal ? "overflow-auto" : ""}`
				: ""
		}`;

		if (initialBuild) {
			return (
				<div className={className}>
					<RenderNodes nodes={nodes} />
				</div>
			);
		}

		return (
			<Transition
				className={className}
				show={true}
				appear={true}
				as="div"
				enter="transition ease-out duration-500"
				enterFrom="transform opacity-0"
				enterTo="transform opacity-100"
			>
				<RenderNodes nodes={nodes} />
			</Transition>
		);
	};

	const content = getContent();

	return (
		<FormContext.Provider
			value={{
				values: data,
				loading,
				submitTriggerId,
				errors,
				submit: triggerSubmit,
				// TODO: rename "setData" to "updateValue" or "updateData", and rename "setDataRaw" to "setData"
				setData: (name: string, value: unknown) =>
					setData((previousData) => ({
						...previousData,
						[name]: value,
					})),
				setDataRaw: setData,
			}}
		>
			<form
				method="POST"
				onSubmit={(event: FormEvent<HTMLFormElement>) => {
					event.preventDefault();
					event.stopPropagation();
					submit();
				}}
				encType="multipart/form-data"
				noValidate={true}
				className="h-full"
			>
				{withPanel ? (
					<Panel
						className="flex h-full flex-col"
						contentClassName={`flex flex-col flex-1 ${
							isInsideModal ? "overflow-auto" : ""
						}`}
						title={title}
						description={description}
						actions={
							<>
								<RenderNodes nodes={actions} />

								{isInsideModal && <CloseModalButton />}
							</>
						}
						withPadding={false}
					>
						{stickyHeader.length > 0 && (
							<div className="flex-none">
								<RenderNodes nodes={stickyHeader} />
							</div>
						)}

						{content}

						{(leftButtons.length > 0 ||
							rightButtons.length > 0) && (
							<PanelFooter
								className={`flex flex-none space-x-4 ${
									leftButtons.length > 0
										? "justify-between"
										: "justify-end"
								} ${isInsideModal ? "shadow-up relative" : ""}`}
							>
								{leftButtons.length > 0 && (
									<div className="flex space-x-4">
										<RenderNodes nodes={leftButtons} />
									</div>
								)}

								{rightButtons.length > 0 && (
									<div className="flex space-x-4">
										<RenderNodes nodes={rightButtons} />
									</div>
								)}
							</PanelFooter>
						)}
					</Panel>
				) : (
					content
				)}

				<button
					ref={refSubmitButton}
					className="hidden"
					type="submit"
					tabIndex={-1}
				/>
			</form>
		</FormContext.Provider>
	);
};
