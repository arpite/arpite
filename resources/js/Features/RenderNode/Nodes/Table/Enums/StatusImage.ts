export const StatusImage = {
	RED: "RED",
	YELLOW: "YELLOW",
	GREEN: "GREEN",
	GRAY: "GRAY",
	BLUE: "BLUE",
	PING_RED: "PING_RED",
	PING_YELLOW: "PING_YELLOW",
	PING_GREEN: "PING_GREEN",
	PING_GRAY: "PING_GRAY",
	PING_BLUE: "PING_BLUE",
};

export type StatusImageType = keyof typeof StatusImage;
