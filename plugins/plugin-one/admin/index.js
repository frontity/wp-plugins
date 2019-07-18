import React from "react";
import { render } from "react-dom";
import { Provider } from "@frontity/connect";
import PluginOne from "./components";
import store from "./store";

const App = () => (
  <Provider value={store}>
    <PluginOne />
  </Provider>
);

render(<App />, document.getElementById("root"));
