import React from "react";
import GlobalStyles from "../../../../components/global-styles";
import Header from "../../../../components/header";
import Main from "./main";
import Footer from "../../../../components/footer";

const YoastPlugin = () => {
  const title = "REST API - Head Tags";
  const slug = "rest-api-head-tags-plugin";
  const docsLink =
    "https://docs.frontity.org/frontity-plugins/rest-api-head-tags";
  const reviewsLink =
    "https://wordpress.org/support/plugin/rest-api-head-tags/reviews/?filter=5";

  return (
    <>
      <GlobalStyles />
      <Header title={title} slug={slug} docsLink={docsLink} />
      <Main />
      <Footer slug={slug} reviewsLink={reviewsLink} />
    </>
  );
};

export default YoastPlugin;
