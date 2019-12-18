import React from "react";
import styled from "@emotion/styled";
import Dropdown from "./dropdown";

const Compatible = () => {
  return (
    <Dropdown margin="56px 0" title="Compatibility">
      <p>
        This plugin is compatible out of the box with most of the SEO plugins,
        but these is the list of plugins we have tested:
      </p>
      <ul>
        <li>
          <h3>Yoast SEO</h3>
        </li>
        <li>
          <h3>All In One SEO Pack</h3>
        </li>
      </ul>
      <p>
        If you test any other plugin please leave a message in our{" "}
        <a href="https://community.frontity.org?utm_source=plugin-dashboard&utm_medium=link&utm_campaign=rest-api-head-tags-plugin" target="_blank">
          community
        </a>{" "}
        so we can update this list.
      </p>
    </Dropdown>
  );
};

export default Compatible;

const headTagsSnippet = `"head_tags": [
  {
    "tag": "title",
    "content": "Hello world! - My Site"
  },
  {
    "tag": "meta",
    "attributes": {
      "name": "robots",
      "content": "max-snippet:-1, max-image-preview:large, max-video-preview:-1"
    }
  },
  {
    "tag": "link",
    "attributes": {
      "rel": "canonical",
      "href": "http://mysite.com/hello-world/"
    }
  }
]
`;

const headTagsHtml = `
  <title>Hello wordl! - My Site</title>
  <meta name="robots" content="max-snippet:-1, max-image-preview:large, max-video-preview:-1">
  <link rel="canonical" href="http://mysite.com/hello-world/" />
`;

const List = styled.ul`
  list-style-type: disc;
  li {
    margin-left: 32px;
  }
`;

const Question = styled.p`
  margin-top: 32px;
  font-weight: bold;
`;

const CodeBlock = styled.pre`
  font-size: small;
  overflow-x: auto;
`;
