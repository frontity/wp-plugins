import React from "react";
import connect from "@frontity/connect";

const ThemeBridge = ({ state, actions }) => (
  <>
    <div>This is Theme Bridge: {state.themeBridge.settings.value}</div>
    <button onClick={actions.themeBridge.setValue}>set Value</button>
  </>
);

export default connect(ThemeBridge);
