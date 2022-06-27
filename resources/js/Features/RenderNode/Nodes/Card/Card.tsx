import React from "react";
import { ButtonInterface } from "../Button";
import { CardSimpleDesign } from "./Designs/CardSimpleDesign";
import { CardVerticalDesign } from "./Designs/CardVerticalDesign";
import { CardDesignEnum, CardDesignEnumType } from "./Enums/CardDesignEnum";

export interface CardInterface {
	nodeType: "Card";
	title: string | null;
	description: string | null;
	image: string | null;
	buttons: ButtonInterface[];
	design: CardDesignEnumType;
}

// eslint-disable-next-line
export interface CardDesignInterface
	extends Pick<
		CardInterface,
		"title" | "description" | "image" | "buttons"
	> {}

export const Card: React.FC<CardInterface> = ({ design, ...props }) => {
	const Tag =
		design === CardDesignEnum.REGULAR
			? CardSimpleDesign
			: CardVerticalDesign;

	return <Tag {...props} />;
};
