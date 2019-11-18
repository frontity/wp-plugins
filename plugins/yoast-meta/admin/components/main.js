import React from "react";
import styled from "@emotion/styled";
import Card from "./card";

const Main = () => {
  return (
    <MainContainer>
      <Card elevated>This is a card.</Card>
    </MainContainer>
  );
};

export default Main;

const MainContainer = styled.main`
  max-width: 600px;
  margin: 64px auto;
`;
