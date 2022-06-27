import i18n from "i18next";
import { initReactI18next } from "react-i18next";

import translationEN from "../i18n/en.json";
import translationLT from "../i18n/lt.json";

const resources = {
	en: {
		translation: translationEN,
	},
	lt: {
		translation: translationLT,
	},
};

i18n.use(initReactI18next).init({
	resources,
	lng: document.documentElement.lang,
	fallbackLng: "en",
	keySeparator: false,
	interpolation: {
		escapeValue: false,
	},
});

export default i18n;
