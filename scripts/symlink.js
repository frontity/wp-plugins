const symlink = require("symlink-dir");
const path = require("path");
const fs = require("fs");
const chalk = require("chalk");
const argv = require("minimist")(process.argv, { boolean: ["production"] });
const args = argv._.slice(2);

if (args.length !== 1) {
  console.warn(
    chalk.red(
      "The `sync` command needs the path to your local WP passed as an argument.\n" +
        "If you are already passing it please check that your path doesn't contain any spaces.\n" +
        "If it does, wrap your path between quotes.\n"
    )
  );

  process.exit(1);
}

const pluginsPath = path.resolve(
  __dirname,
  argv.production ? "../build" : "../plugins"
);

console.log(`Getting plugins from:\n${chalk.yellow(pluginsPath)}\n`);

const wpPluginsPath = args[0].endsWith("/wp-content/plugins")
  ? args[0]
  : `${args[0]}/wp-content/plugins`;

console.log(`Creating symlinks on:\n${chalk.yellow(wpPluginsPath)}\n`);

const pluginsList = fs.readdirSync(pluginsPath).filter(plugin => {
  const pluginPath = path.resolve(pluginsPath, plugin);
  return fs.existsSync(pluginPath) && fs.lstatSync(pluginPath).isDirectory();
});

pluginsList.forEach(plugin => {
  symlink(`${pluginsPath}/${plugin}`, `${wpPluginsPath}/${plugin}`);
});

console.log(chalk.green("Symlinks created.\n"));
