import { useEffect, useState } from "react";

export const useMobileLayout = () => {
	const [isMobileLayout, setMobileLayout] = useState(
		window.innerWidth <= 1024
	);

	const handleResize = () => {
		setMobileLayout(window.innerWidth <= 1024);
	};

	useEffect(() => {
		window.addEventListener("resize", handleResize);

		return () => {
			window.removeEventListener("resize", handleResize);
		};
	}, []);

	return {
		isMobileLayout,
	};
};
