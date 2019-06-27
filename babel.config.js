module.exports = {
  presets: [
    [
      "@babel/preset-env",
      {
        targets: {
          edge: "16",
          firefox: "50",
          chrome: "50",
          safari: "10"
        },
        useBuiltIns: "entry",
        corejs: 3
      }
    ],
    "@babel/preset-react"
  ]
};
