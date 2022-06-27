import fs from "fs";
import { randomBytes } from "crypto";

const FILES = ["/resources/dist/index.css", "/resources/dist/index.js", "/resources/dist/index.js.map"];

const hash = randomBytes(8).toString("hex");

const manifest = FILES.reduce(
	(manifest, file) => ({ ...manifest, [file]: `${file}?id=${hash}` }),
	{}
);

fs.writeFileSync(`resources/dist/mix-manifest.json`, JSON.stringify(manifest));
