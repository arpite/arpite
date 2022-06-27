import { useEffect, useState } from "react";

export const useIsLG = () => {
	const [isLG, setIsLG] = useState(window.innerWidth >= 1280);

	const handleResize = () => {
		setIsLG(window.innerWidth >= 1280);
	};

	useEffect(() => {
		window.addEventListener("resize", handleResize);

		return () => {
			window.removeEventListener("resize", handleResize);
		};
	}, []);

	return {
		isLG,
	};
};
