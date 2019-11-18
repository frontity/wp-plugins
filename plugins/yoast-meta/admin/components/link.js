import React from "react";
import styled from "@emotion/styled";

const Link = ({ icon, children, ...props }) => {
  return (
    <Anchor {...props}>
      {icon || null}
      <span>{children}</span>
    </Anchor>
  );
};

export default Link;

const Anchor = styled.a`
  color: #1f38c5;
  font-size: 12px;
  font-weight: 600;
  line-height: 1.33;
  letter-spacing: 1.2px;
  text-transform: uppercase;
  text-decoration: none;
  white-space: nowrap;
  cursor: pointer;

  svg {
    height: 16px;
    width: 16px;
    margin-right: 8px;
    vertical-align: text-bottom;
  }

  span {
    padding-bottom: 4px;
    border-bottom: 2px solid rgba(32, 56, 197, 0.3);
  }

  &:hover,
  &:focus {
    color: #1f38c5;
    text-decoration: none;
    span {
      border-bottom: 2px solid #1f38c5;
    }
  }
`;
