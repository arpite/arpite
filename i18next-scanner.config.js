module.exports = {
	input: ["./resources/js/**/*.{tsx,ts}"],
	options: {
		debug: true,
		removeUnusedKeys: true,
		func: {
			list: ["t"],
			extensions: [".tsx", ".ts"],
		},
		lngs: ["en", "lt"],
		defaultLng: "en",
		defaultValue: (lng, _, key) => {
			if (lng === "en") {
				return key;
			}

			return "__NOT_TRANSLATED__";
		},
		resource: {
			loadPath: "./resources/i18n/{{lng}}.json",
			savePath: "./resources/i18n/{{lng}}.json",
			jsonIndent: 4,
		},
		nsSeparator: false,
		keySeparator: false,
	},
};
