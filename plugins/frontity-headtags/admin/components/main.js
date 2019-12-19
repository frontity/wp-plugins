import React from "react";
import styled from "@emotion/styled";
import Info from "./info";
import Settings from "./settings";
import Compatible from "./compatible";

const Main = () => {
  return (
    <MainContainer>
      <Settings />
      <Info />
      <Compatible />
      
    </MainContainer>
  );
};

export default Main;

const MainContainer = styled.main`
  max-width: 700px;
  margin: 64px auto;
  padding: 0 16px;
`;
