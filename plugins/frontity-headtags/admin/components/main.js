import React from "react";
import styled from "@emotion/styled";
import Settings from "./settings";
import CardLink from "../../../../components/card-link";

const Main = () => {
  return (
    <MainContainer>
      <Settings />
      <CardLink href="https://docs.frontity.org/frontity-plugins/rest-api-head-tags#how-to-use-this-plugin?utm_source=plugin-dashboard&utm_medium=link&utm_campaign=rest-api-head-tags-plugin">
        How to use REST API Head Tags plugin
      </CardLink>
      <CardLink href="https://docs.frontity.org/frontity-plugins/rest-api-head-tags#compatibility?utm_source=plugin-dashboard&utm_medium=link&utm_campaign=rest-api-head-tags-plugin">
        Compatibility
      </CardLink>
    </MainContainer>
  );
};

export default Main;

const MainContainer = styled.main`
  max-width: 700px;
  margin: 64px auto;
  padding: 0 16px;
`;
