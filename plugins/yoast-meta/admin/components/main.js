import React from "react";
import styled from "@emotion/styled";
import Card from "./card";
import Toggle from "./toggle";

const Main = () => {
  const [checked, setChecked] = React.useState(false);
  const toggleChecked = () => setChecked(!checked);

  return (
    <MainContainer>
      <Card margin="56px 0">This is a card.</Card>
      <Card margin="56px 0">
        <h2>Setting option here?</h2>
        <p>Activate this option to...</p>
        <Toggle checked={checked} onClick={toggleChecked} />
      </Card>
    </MainContainer>
  );
};

export default Main;

const MainContainer = styled.main`
  max-width: 968px;
  margin: 64px auto;
  padding: 0 16px;
`;
