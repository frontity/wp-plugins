import React from "react";
import connect from "@frontity/connect";
import GlobalStyles from "./global-styles";
import Header from "./header";
import Main from "./main";
import Footer from "./footer";

const YoastPlugin = ({ state, actions }) => {
  const { isEnabled } = state.yoast.settings;
  const { enable, disable } = actions.yoast;
  return (
    <>
      <GlobalStyles />
      <Header />
      <Main />
      <Footer />
    </>
  );
};

export default connect(YoastPlugin);
