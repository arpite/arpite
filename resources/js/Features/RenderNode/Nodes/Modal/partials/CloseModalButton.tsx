import { mdiClose } from "@mdi/js";
import React, { useContext } from "react";
import { useTranslation } from "react-i18next";
import { Icon } from "../../../../Icon";
import ModalContext from "../ModalContext";

interface CloseButtonInterface {
	className?: string;
}

export const CloseModalButton: React.FC<CloseButtonInterface> = ({
	className,
}) => {
	const { t } = useTranslation();

	const { closeModal } = useContext(ModalContext);

	return (
		<button
			className={`focus:shadow-outline rounded-md text-gray-600 transition duration-150 hover:text-gray-500 ${
				className ?? ""
			}`}
			type="button"
			onClick={closeModal}
		>
			<span className="sr-only">{t("Close")}</span>
			<Icon icon={mdiClose} className="h-6 w-6" aria-hidden="true" />
		</button>
	);
};
