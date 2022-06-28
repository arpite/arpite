import { defineConfig } from "vite";
import react from "@vitejs/plugin-react";

export default defineConfig({
	build: {
		rollupOptions: {
			input: "resources/js/index.tsx",
			output: {
				entryFileNames: "arpite.js",
			},
		},
		outDir: "resources/dist",
		target: "esnext",
	},
	plugins: [react()],
});
