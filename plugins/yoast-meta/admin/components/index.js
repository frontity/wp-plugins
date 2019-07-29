import React from "react";
import connect from "@frontity/connect";

const YoastMetaPlugin = ({ state, actions }) => (
  <>
    <div>
      This is REST API Yoast Meta by Frontity: {state.yoastMeta.settings.value}
    </div>
    <button onClick={actions.yoastMeta.setValue}>set Value</button>
  </>
);

export default connect(YoastMetaPlugin);
