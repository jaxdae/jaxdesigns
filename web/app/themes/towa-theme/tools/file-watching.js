/* eslint-disable no-console */
const fs = require("fs");

const tmpPath = "./tools/tmp";

if (!fs.existsSync(tmpPath)) {
  fs.mkdir(tmpPath, err => {
    if (err) {
      console.log("failed to create tmp directory", err);
    } else {
      fs.writeFileSync(`${tmpPath}/timestamp.js`, `// ${Date.now()}`);
    }
  });
} else {
  fs.writeFileSync(`${tmpPath}/timestamp.js`, `// ${Date.now()}`);
}
