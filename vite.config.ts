import { defineConfig } from "vite";
import react from "@vitejs/plugin-react";
import dts from "vite-dts";

export default defineConfig({
	build: {
		lib: {
			entry: "resources/js/index.ts",
			formats: ["es", "cjs"],
		},
		rollupOptions: {
			external: ["react", "react-dom"],
			output: {
				sourcemapExcludeSources: true,
			},
		},
		outDir: "resources/dist-module",
		target: "esnext",
		sourcemap: true,
		minify: false,
	},
	plugins: [react(), dts()],
});
