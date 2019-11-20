import React from "react";
import styled from "@emotion/styled";
import Card from "./card";
import Toggle from "./toggle";
import Button from "./button";

const Settings = () => {
  const [checked, setChecked] = React.useState(false);
  const toggleChecked = () => setChecked(!checked);

  return (
    <Card margin="56px 0">
      <h2>Settings</h2>
      {/* <p>Activate this option to...</p> */}
      <Field>
        <Label>enabled</Label>
        <InputContainer>
          <Toggle checked={checked} onClick={toggleChecked} />
        </InputContainer>
        <Description>
          Check this option to enable output to the REST API responses.
        </Description>
      </Field>
      <Field>
        <Label>head tags cache</Label>
        <InputContainer>
          <Button>purge cache</Button>
        </InputContainer>
        <Description>
          Delete cached head tags for all entities (i.e. post types, authors,
          taxonomies...)
        </Description>
      </Field>
    </Card>
  );
};

export default Settings;

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
