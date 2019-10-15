const path = require("path");
const connect = require("simple-git/promise");
const replace = require("replace-in-file");
const packageJson = require(path.join(process.cwd(), "./package.json"));

(async () => {
  const options = {
    files: "plugin.php",
    from: [/Version: \d+\.\d+\.\d+/, /_VERSION', '\d+\.\d+\.\d+'\)/],
    to: [
      `Version: ${packageJson.version}`,
      `_VERSION', '${packageJson.version}')`
    ]
  };
  try {
    const changes = await replace(options);
    console.log("Modified files:", changes.join(", "));
    const repo = await connect(".");
    await repo.checkout("master");
    await repo.add(["plugin.php"]);
    console.log("Files added.");
  } catch (error) {
    console.error("Error occurred:", error);
  }
})();
