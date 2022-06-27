import React from "react";
import { render } from "react-dom";
import { InertiaApp } from "@inertiajs/inertia-react";
import StructuredPage from "./Pages/StructuredPage";
import { InertiaProgress } from "@inertiajs/progress";
import "./i18n";

export class Cygnus {
	private static customNodes: Record<string, React.FC<any>> = {};

	public static getCustomNodes() {
		return this.customNodes;
	}

	public static addNodes(nodes: Record<string, React.FC<any>>) {
		Cygnus.customNodes = { ...Cygnus.customNodes, ...nodes };

		return this;
	}

	public static render() {
		const element = document.getElementById("app");

		if (element && element.dataset.page) {
			InertiaProgress.init({ color: "#4B5563" });

			render(
				<InertiaApp
					initialPage={JSON.parse(element.dataset.page)}
					resolveComponent={() => StructuredPage}
				/>,
				element
			);
		}
	}
}
