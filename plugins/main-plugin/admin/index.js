import React from "react";
import { render } from "react-dom";
import MainPlugin from "./components";
import PluginOne from "../../plugin-one/admin/components";
import PluginTwo from "../../plugin-two/admin/components";

render(
  <>
    <MainPlugin />
    <PluginOne />
    <PluginTwo />
  </>,
  document.getElementById("root")
);
