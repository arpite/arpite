import { useEffect } from "react";
import { Inertia } from "@inertiajs/inertia";

export const useTesting = () => {
	useEffect(() => {
		// eslint-disable-next-line
		if ((window as any).inertiaEventsCount === undefined) {
			// eslint-disable-next-line
			(window as any).inertiaEventsCount = {
				navigateCount: 0,
				successCount: 0,
				errorCount: 0,
			};
		}

		Inertia.on("navigate", () => {
			// eslint-disable-next-line
			(window as any).inertiaEventsCount.navigateCount++;
		});

		Inertia.on("success", () => {
			// eslint-disable-next-line
			(window as any).inertiaEventsCount.successCount++;
		});

		Inertia.on("error", () => {
			// eslint-disable-next-line
			(window as any).inertiaEventsCount.errorCount++;
		});
	}, []);
};
