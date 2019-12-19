import React from "react";
import styled from "@emotion/styled";

const Check = ({ color, size }) => (
  <Svg viewBox="0 0 24 24" fill={color || "currentColor"} size={size}>
    <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z" />
  </Svg>
);

export default Check;

const Svg = styled.svg`
  width: ${({ size }) => size}px;
  height: ${({ size }) => size}px;
  flex-shrink: 0;
  flex-growth: 0;
`;
