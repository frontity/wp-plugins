import React from "react";
import connect from "@frontity/connect";

const PluginOne = ({ state, actions }) => (
  <>
    <div>This is Plugin One: {state.pluginOne.settings.value}</div>
    <button onClick={actions.pluginOne.setValue}>set Value</button>
  </>
);

export default connect(PluginOne);
