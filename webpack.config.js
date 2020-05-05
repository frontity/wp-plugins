const path = require("path");

module.exports = {
  mode: process.env.NODE === "production" ? "production" : "development",
  entry: {
    "plugins/frontity-main-plugin/admin/build/bundle":
      "./plugins/frontity-main-plugin/admin",
    "plugins/frontity-plugin-one/admin/build/bundle":
      "./plugins/frontity-plugin-one/admin",
    "plugins/frontity-plugin-two/admin/build/bundle":
      "./plugins/frontity-plugin-two/admin",
    "plugins/frontity-headtags/admin/build/bundle":
      "./plugins/frontity-headtags/admin",
    "plugins/frontity-theme-bridge/admin/build/bundle":
      "./plugins/frontity-theme-bridge/admin",
  },
  output: {
    path: path.resolve("./"),
    filename: "[name].js",
  },
  module: {
    rules: [
      {
        test: /\.js$/,
        use: "babel-loader",
      },
    ],
  },
};
