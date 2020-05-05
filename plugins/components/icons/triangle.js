import React from "react";
import styled from "@emotion/styled";

export default ({ color, size, pointingDown }) => (
  <Svg
    viewBox="0 0 6.879 4.233"
    fill={color || "currentColor"}
    size={size}
    pointingDown={pointingDown}
  >
    <path d="M0 4.233L3.44 0l3.44 4.233z" />
  </Svg>
);

const Svg = styled.svg`
  width: ${({ size }) => size}px;
  height: ${({ size }) => size}px;
  flex-shrink: 0;
  flex-growth: 0;
  transform: ${({ pointingDown }) =>
    pointingDown ? "rotate(180deg)" : "none"};
`;
