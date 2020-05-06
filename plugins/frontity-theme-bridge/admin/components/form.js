import React from "react";
import styled from "@emotion/styled";
import connect from "@frontity/connect";

const Form = ({ state, actions }) => {
  const onSubmit = (e) => {
    e.preventDefault();
    actions.themeBridge.save();
  };
  return (
    <form id="settings" onSubmit={onSubmit}>
      <Container>
        <Title>Server Url</Title>
        <Input
          placeholder="http://localhost:3000"
          type="url"
          required
          onChange={(e) => {
            actions.themeBridge.setFormPropString({
              name: "serverUrl",
              value: e.target.value,
            });
          }}
        ></Input>
      </Container>
      <Container>
        <Title>Static Url</Title>
        <Input
          placeholder="http://localhost:3000"
          type="url"
          onChange={(e) => {
            actions.themeBridge.setFormPropString({
              name: "staticUrl",
              value: e.target.value,
            });
          }}
        ></Input>
      </Container>
      <SaveButton type="submit">Save</SaveButton>
    </form>
  );
};

export default connect(Form);

const Container = styled.div`
  display: flex;
`;
const Title = styled.h3`
  display: block;
`;

const Input = styled.input`
  display: block;
`;

const SaveButton = styled.button`
  color: blue;
`;
