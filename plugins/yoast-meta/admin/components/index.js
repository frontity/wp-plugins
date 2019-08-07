import React from "react";
import connect from "@frontity/connect";

const YoastPlugin = ({ state, actions }) => {
  const { isEnabled } = state.yoast.settings;
  const { enable, disable } = actions.yoast;
  return (
    <div className="wrap">
      <h1>REST API Yoast Meta by Frontity</h1>
      <button
        className="button button-primary"
        onClick={isEnabled ? disable : enable}
      >
        {isEnabled ? "Disable" : "Enable"}
      </button>
    </div>
  );
};

export default connect(YoastPlugin);
