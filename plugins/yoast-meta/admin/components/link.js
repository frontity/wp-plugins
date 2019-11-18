import React from "react";
import styled from "@emotion/styled";

const Link = ({ icon, children, ...props }) => {
  return (
    <a {...props}>
      {icon || null}
      <Text>{children}</Text>
    </a>
  );
};

export default Link;

const Text = styled.span`
  font-family: Poppins;
  font-size: 12px;
  font-weight: 600;
  font-stretch: normal;
  font-style: normal;
  line-height: 1.33;
  letter-spacing: 1.2px;
  color: #1f38c5;
`;
