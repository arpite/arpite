/**
 * More information: https://tailwindcss.com/docs/customizing-colors#using-css-variables
 */
const withOpacityValue = (variable) => {
	return ({ opacityValue }) => {
		if (opacityValue === undefined) {
			return `rgb(${variable})`;
		}

		return `rgb(${variable} / ${opacityValue})`;
	};
};

module.exports = {
	content: ["./resources/js/**/*.tsx"],
	// content: ["./resources/views/app.blade.php", "./resources/js/**/*.tsx"],
	theme: {
		screens: {
			xs: "425px",
			sm: "640px",
			md: "768px",
			lg: "1024px",
			xl: "1280px",
			"2xl": "1536px",
		},
		extend: {
			colors: {
				primary: {
					50: withOpacityValue`var(--arpite-primary-50, 236 253 245)`,
					100: withOpacityValue`var(--arpite-primary-100, 209 250 229)`,
					200: withOpacityValue`var(--arpite-primary-200, 167 243 208)`,
					300: withOpacityValue`var(--arpite-primary-300, 110 231 183)`,
					400: withOpacityValue`var(--arpite-primary-400, 52 211 153)`,
					500: withOpacityValue`var(--arpite-primary-500, 16 185 129)`,
					600: withOpacityValue`var(--arpite-primary-600, 5 150 105)`,
					700: withOpacityValue`var(--arpite-primary-700, 4 120 87)`,
					800: withOpacityValue`var(--arpite-primary-800, 6 95 70)`,
					900: withOpacityValue`var(--arpite-primary-900, 6 78 59)`,
				},
			},
			backgroundColor: {
				background: "#F4F5F7",
			},
			fontFamily: {
				base: '"Inter", sans-serif',
			},
		},
	},
	plugins: [require("@tailwindcss/forms")],
};
