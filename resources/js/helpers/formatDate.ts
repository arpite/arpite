export const formatDate = (givenDate: Date | string) => {
	const date =
		typeof givenDate === "string" ? new Date(givenDate) : givenDate;

	return (
		date.getFullYear() +
		"-" +
		twoDigits(1 + date.getMonth()) +
		"-" +
		twoDigits(date.getDate())
	);
};

export const formatTime = (givenDate: Date | string) => {
	const date =
		typeof givenDate === "string" ? new Date(givenDate) : givenDate;

	return twoDigits(date.getHours()) + ":" + twoDigits(date.getMinutes());
};

export const formatDateTime = (givenDate: Date | string) => {
	const date =
		typeof givenDate === "string" ? new Date(givenDate) : givenDate;

	return formatDate(date) + " " + formatTime(date);
};

const twoDigits = (digit: number) => {
	if (0 <= digit && digit < 10) {
		return "0" + digit.toString();
	}

	if (-10 < digit && digit < 0) {
		return "-0" + (-1 * digit).toString();
	}

	return digit.toString();
};
