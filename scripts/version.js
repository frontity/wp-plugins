const path = require("path");
const connect = require("simple-git/promise");
const fs = require("fs-extra");
const replace = require("replace-in-file");

(async () => {
  try {
    const plugins = await fs.readdir("plugins");
    plugins.forEach(async folder => {
      const packageJson = require(`../plugins/${folder}/package.json`);
      const changes = await replace({
        files: `plugins/${folder}/plugin.php`,
        from: [/Version: \d+\.\d+\.\d+/, /_VERSION', '\d+\.\d+\.\d+'/],
        to: [
          `Version: ${packageJson.version}`,
          `_VERSION', '${packageJson.version}'`
        ]
      });
      if (changes.length > 0)
        console.log(
          `Updated plugin.php for "${folder}" with version "${packageJson.version}".`
        );
    });
  } catch (error) {
    console.error("Error occurred:", error);
  }
})();
