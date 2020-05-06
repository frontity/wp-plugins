import React from "react";
import styled from "@emotion/styled";
import connect from "@frontity/connect";
import Card from "../../../../components/card";
import Form from "./form";

const Settings = ({ state, actions }) => {
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
        <Form />
      </div>
    </Card>
  );
};

export default connect(Settings);

const Title = styled.h2`
  display: inline;
  padding-right: 15px;
`;
