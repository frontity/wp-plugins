const path = require("path");

module.exports = {
  mode: process.env.NODE === "production" ? "production" : "development",
  entry: {
    "plugins/main-plugin/admin/build/bundle": "./plugins/main-plugin/admin",
    "plugins/plugin-one/admin/build/bundle": "./plugins/plugin-one/admin",
    "plugins/plugin-two/admin/build/bundle": "./plugins/plugin-two/admin",
    "plugins/frontity-headtags/admin/build/bundle":
      "./plugins/frontity-headtags/admin"
  },
  output: {
    path: path.resolve("./"),
    filename: "[name].js"
  },
  module: {
    rules: [
      {
        test: /\.js$/,
        use: "babel-loader"
      }
    ]
  }
};
