const webpack = require("webpack");
const config = require("../webpack.config");
const fs = require("fs-extra");
const path = require("path");
const replace = require("replace-in-file");

const BUILD_FOLDER = path.resolve(__dirname, "../build");
const PLUGINS_FOLDER = path.resolve(__dirname, "../plugins");
const MAIN_PLUGIN = "main-plugin";

(async () => {
  // Build UI in production mode
  webpack(config).run();

  // Ensure build folder is empty
  await fs.emptyDir(BUILD_FOLDER);

  // Get all plugins from the plugins folder
  const plugins = await fs.readdir(PLUGINS_FOLDER);

  // For each plugin...
  await Promise.all(
    plugins.map(async plugin => {
      const pluginPath = path.join(PLUGINS_FOLDER, plugin);
      const buildPath = path.join(BUILD_FOLDER, plugin);

      // Copy it to ./build/PLUGIN folder
      // - without package.json
      // - without node_modules
      // - without src files inside admin folders
      await fs.copy(pluginPath, buildPath, {
        filter: file =>
          !(
            file.includes("package.json") ||
            file.includes("node_modules") ||
            (file.includes("admin/") &&
              !file.endsWith(".php") &&
              !file.includes("admin/build"))
          )
      });

      if (plugin === MAIN_PLUGIN) {
        // Change "require-dev" by "require-prod"
        await replace({
          files: path.join(buildPath, "plugin.php"),
          from: /require-dev/,
          to: "require-prod"
        });
      } else {
        // Copy it also to ./build/MAIN_PLUGIN/plugins/PLUGIN folder
        // - without package.json
        // - without node_modules
        // - without admin
        // - without plugin.php
        const subpluginPath = path.join(BUILD_FOLDER, MAIN_PLUGIN, "plugins");
        await fs.ensureDir(subpluginPath);
        await fs.copy(pluginPath, subpluginPath, {
          filter: file =>
            !(
              file.includes("package.json") ||
              file.includes("node_modules") ||
              file.includes("admin") ||
              file.includes("plugin.php")
            )
        });
      }
    })
  );
})();
