import React from "react";
import styled from "@emotion/styled";
import connect from "@frontity/connect";
import Card from "../../../components/card";
import Toggle from "../../../components/toggle";
import Button from "../../../components/button";
import ModalPurgeCache from "./modal-purge-cache";

const Settings = ({ state, actions }) => {
  const { isEnabled } = state.headtags.settings;
  const { enable, disable, openCacheModal } = actions.headtags;

  return (
    <Card margin="56px 0">
      <div>
        <Title>Settings</Title>
        <a
          href="https://docs.frontity.org/frontity-plugins/rest-api-head-tags#settings?utm_source=plugin-dashboard&utm_medium=link&utm_campaign=rest-api-head-tags-plugin"
          target="_blank"
        >
          Learn More
        </a>
      </div>
      <Field>
        <Label>enabled</Label>
        <InputContainer>
          <Toggle checked={isEnabled} onClick={isEnabled ? disable : enable} />
        </InputContainer>
        <Description>
          Disable if you just want to get this data with the query:
          <CodeBlock> ?head_tags=true</CodeBlock>.
        </Description>
      </Field>
      <Field>
        <Label>head tags cache</Label>
        <InputContainer>
          <Button onClick={openCacheModal}>purge cache</Button>
        </InputContainer>
        <Description>
          Delete cached head tags for all entities (post types, authors,
          taxonomies and archives).
        </Description>
      </Field>

      <ModalPurgeCache />
    </Card>
  );
};

export default connect(Settings);

const CodeBlock = styled.pre`
  display: inline;
`;

const Title = styled.h2`
  display: inline;
  padding-right: 15px;
`;

const Field = styled.div`
  display: flex;
  min-height: 48px;
  margin-top: 20px;

  @media (max-width: 669px) {
    align-items: flex-start;
    flex-direction: column;
    & > *:not(:last-child) {
      margin-bottom: 16px;
    }
  }

  @media (min-width: 670px) {
    align-items: center;
    & > *:not(:last-child) {
      margin-right: 32px;
    }
  }
`;

const Label = styled.label`
  width: 184px;
  flex-shrink: 0;
  flex-growth: 0;
`;

const InputContainer = styled.span`
  flex-shrink: 0;
  flex-growth: 0;
`;

const Description = styled.span`
  color: rgba(12, 17, 43, 0.4);
`;
