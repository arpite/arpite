import React from "react";

export interface PricingPlansContextInterface {
	activeInterval: "monthly" | "yearly";
}

const PricingPlansContext = React.createContext<PricingPlansContextInterface>({
	activeInterval: "yearly",
});

export default PricingPlansContext;
