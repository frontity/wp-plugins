import React from "react";
import styled from "@emotion/styled";
import connect from "@frontity/connect";
import Card from "./card";
import Toggle from "./toggle";
import Button from "./button";

const Settings = ({ state, actions }) => {
  const { isEnabled } = state.headtags.settings;
  const { enable, disable, clearCache } = actions.headtags;

  return (
    <Card margin="56px 0">
      <h2>Settings</h2>
      <Field>
        <Label>enabled</Label>
        <InputContainer>
          <Toggle checked={isEnabled} onClick={isEnabled ? disable : enable} />
        </InputContainer>
        <Description>
          Check this option to enable output to the REST API responses.
        </Description>
      </Field>
      <Field>
        <Label>head tags cache</Label>
        <InputContainer>
          <Button onClick={clearCache}>purge cache</Button>
        </InputContainer>
        <Description>
          Delete cached head tags for all entities (post types, authors,
          taxonomies and archives).
        </Description>
      </Field>
    </Card>
  );
};

export default connect(Settings);

const Field = styled.div`
  display: flex;
  min-height: 48px;
  margin-top: 20px;
  align-items: center;

  @media (max-width: 669px) {
    flex-wrap: wrap;
  }
`;

const Label = styled.label`
  width: 184px;
  padding-right: 16px;
  flex-shrink: 0;
  flex-growth: 0;
`;

const InputContainer = styled.span`
  flex-shrink: 0;
  flex-growth: 0;
`;

const Description = styled.span`
  padding-left: 32px;
  color: rgba(12, 17, 43, 0.4);
`;
