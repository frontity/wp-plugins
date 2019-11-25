import React from "react";
import styled from "@emotion/styled";

const Button = ({ icon, primary, children, ...props }) => {
  return (
    <Anchor primary={primary} {...props}>
      {icon || null}
      <span>{children}</span>
    </Anchor>
  );
};

export default Button;

const Anchor = styled.button`
  height: 32px;
  padding: 0 16px;
  display: flex;
  flex-direction: row;
  align-items: center;
  border-radius: 8px;
  box-sizing: border-box;
  box-shadow: ${({ primary }) =>
    primary
      ? "0 1px 4px 0 rgba(12, 17, 43, 0.16), 0 4px 8px 0 rgba(12, 17, 43, 0.12)"
      : "0 1px 4px 0 rgba(12, 17, 43, 0.12), 0 1px 4px 0 rgba(12, 17, 43, 0.16)"};

  background-color: ${({ primary }) => (primary ? "#1f38c5" : "#ffffff")};
  color: ${({ primary }) => (primary ? "#ffffff" : "#1f38c5")};
  border: ${({ primary }) =>
    primary ? "none" : "solid 2px rgba(32, 56, 197, 0.4)"};

  &:focus,
  &:hover {
    color: ${({ primary }) => (primary ? "#ffffff" : "#1f38c5")};
    border: ${({ primary }) =>
      primary ? "none" : "solid 2px rgba(32, 56, 197)"};
  }

  font-family: Poppins, sans-serif;
  font-size: 12px;
  font-weight: 600;
  font-stretch: normal;
  font-style: normal;
  line-height: 1.33;
  letter-spacing: 1.2px;
  text-transform: uppercase;
  text-decoration: none;
  white-space: nowrap;

  cursor: pointer;

  svg {
    width: 12px;
    height: 12px;
    padding-right: 8px;
  }
`;
