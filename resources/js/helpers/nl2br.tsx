import React from "react";

export const nl2br = (text: string) => {
	return text.split("\n").map((line, index) => {
		if (index > 0) {
			return [<br key={`br-${index}`} />, line];
		}

		return line;
	});
};
