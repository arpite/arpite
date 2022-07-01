const defaultTheme = require('tailwindcss/defaultTheme');

/** @type {import('tailwindcss/tailwind-config').TailwindConfig} */
module.exports = {
	content: ["./resources/js/**/*.{tsx,ts}"],
	theme: {
		extend: {
			screens: {
				xs: "425px",
			},
			colors: {
				primary: {
					50: 'rgb(var(--arpite-primary-50, 236 253 245) / <alpha-value>)',
					100: 'rgb(var(--arpite-primary-100, 209 250 229) / <alpha-value>)',
					200: 'rgb(var(--arpite-primary-200, 167 243 208) / <alpha-value>)',
					300: 'rgb(var(--arpite-primary-300, 110 231 183) / <alpha-value>)',
					400: 'rgb(var(--arpite-primary-400, 52 211 153) / <alpha-value>)',
					500: 'rgb(var(--arpite-primary-500, 16 185 129) / <alpha-value>)',
					600: 'rgb(var(--arpite-primary-600, 5 150 105) / <alpha-value>)',
					700: 'rgb(var(--arpite-primary-700, 4 120 87) / <alpha-value>)',
					800: 'rgb(var(--arpite-primary-800, 6 95 70) / <alpha-value>)',
					900: 'rgb(var(--arpite-primary-900, 6 78 59) / <alpha-value>)',
				},
			},
			backgroundColor: {
				background: "#F4F5F7",
			},
			fontFamily: {
				sans: ['Inter var', ...defaultTheme.fontFamily.sans]
			}
		},
	},
	plugins: [require("@tailwindcss/forms")],
};
