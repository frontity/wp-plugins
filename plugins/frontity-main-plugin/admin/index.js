import React from "react";
import { render } from "react-dom";
import { Provider, createStore } from "@frontity/connect";
import MainPlugin from "./components";
import PluginOne from "../../frontity-plugin-one/admin/components";
import PluginTwo from "../../frontity-plugin-two/admin/components";
import HeadTags from "../../frontity-headtags/admin/components";
import config from "./config";

// Init store and expose it in window.frontity
const store = createStore(config);
window.frontity.state = store.state;
window.frontity.actions = store.actions;

const App = () => (
  <Provider value={store}>
    <MainPlugin />
    <PluginOne />
    <PluginTwo />
    <HeadTags />
  </Provider>
);

render(<App />, document.getElementById("root"));
