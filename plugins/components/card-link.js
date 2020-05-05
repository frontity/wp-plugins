import React from "react";
import styled from "@emotion/styled";
import TinyCard from "./tiny-card";
import Arrow from "./icons/arrow";

const CardLink = ({ children, ...props }) => {
  return (
    <Link {...props}>
      <TinyCard margin="32px auto">
        <Arrow color="#1f38c5" size={32} /> <span>{children}</span>
      </TinyCard>
    </Link>
  );
};

export default CardLink;

const Link = styled.a`
  color: #1f38c5;
  font-size: 12px;
  font-weight: 600;
  line-height: 1.33;
  letter-spacing: 1.2px;
  text-transform: uppercase;
  text-decoration: none;
  white-space: nowrap;
  cursor: pointer;
  &:hover,
  &:focus {
    color: #1f38c5;
    text-decoration: none;
    span {
      border-bottom: 2px solid #1f38c5;
    }
  }
`;
