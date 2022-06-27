import React from "react";

interface ModalContextInterface {
	isInsideModal: boolean;
	closeModal: () => void;
}

const ModalContext = React.createContext<ModalContextInterface>({
	isInsideModal: false,
	closeModal: () => {},
});

export default ModalContext;
