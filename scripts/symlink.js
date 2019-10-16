const symlink = require("symlink-dir");
const path = require("path");
const fs = require("fs");

const args = process.argv.slice(2);
const prod = process.env.NODE === "production";

if (args.length !== 1)
  throw new Error(
    "The `sync` command needs the path to your local WP passed as an argument.\n" +
      "If you are already passing it please check that your path doesn't contain any spaces.\n" +
      "If it does, wrap your path between quotes."
  );

console.log("Creating symlinks to the plugins on your local WP...");

const pluginsPath = path.resolve(__dirname, prod ? "../build" : "../plugins");
const wpPluginsPath = args[0].endsWith("/wp-content/plugins")
  ? args[0]
  : `${args[0]}/wp-content/plugins`;

const pluginsList = fs.readdirSync(pluginsPath).filter(plugin => {
  const pluginPath = path.resolve(pluginsPath, plugin);
  return fs.existsSync(pluginPath) && fs.lstatSync(pluginPath).isDirectory();
});

pluginsList.forEach(plugin => {
  symlink(`${pluginsPath}/${plugin}`, `${wpPluginsPath}/${plugin}`);
});

console.log("Symlinks created.");
