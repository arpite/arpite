import React, { ReactElement } from "react";

interface PanelContextInterface {
	setHeaderOverlay: (overlay: ReactElement | null) => void;
}

const PanelContext = React.createContext<PanelContextInterface>({
	setHeaderOverlay: () => {
		console.error("No panel found!");
	},
});

export default PanelContext;
