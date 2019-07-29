import React from "react";
import connect from "@frontity/connect";

const YoastPlugin = ({ state, actions }) => {
  const { isActive } = state.yoast.settings;
  const { activate, deactivate } = actions.yoast;
  return (
    <>
      <div>REST API Yoast Meta by Frontity</div>
      <button onClick={isActive ? deactivate : activate}>
        {isActive ? "Deactivate" : "Activate"}
      </button>
    </>
  );
};

export default connect(YoastPlugin);
