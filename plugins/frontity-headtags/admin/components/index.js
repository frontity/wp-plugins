import React from "react";
import GlobalStyles from "./global-styles";
import Header from "./header";
import Main from "./main";
import Footer from "./footer";

const YoastPlugin = () => {
  return (
    <>
      <GlobalStyles />
      <Header />
      <Main />
      <Footer />
    </>
  );
};

export default YoastPlugin;
