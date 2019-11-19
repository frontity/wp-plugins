import React from "react";
import styled from "@emotion/styled";

const Close = ({ color, size }) => (
  <Svg viewBox="0 0 24 24" fill={color || "currentColor"} size={size}>
    <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z" />
  </Svg>
);

export default Close;

const Svg = styled.svg`
  width: ${({ size }) => size}px;
  height: ${({ size }) => size}px;
  flex-shrink: 0;
  flex-growth: 0;
`;
