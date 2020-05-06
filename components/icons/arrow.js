import React from "react";
import styled from "@emotion/styled";

export default ({ color, size }) => (
  <Svg
    size={size}
    viewBox="0 0 24 24"
    preserveAspectRatio="xMidYMid meet"
    height="1em"
    width="1em"
    fill="none"
    xmlns="http://www.w3.org/2000/svg"
    viewBox="0 0 24 24"
    stroke-width="2"
    stroke-linecap="round"
    stroke-linejoin="round"
    stroke={color || "currentColor"}
  >
    <g>
      <line x1="5" y1="12" x2="19" y2="12"></line>
      <polyline points="12 5 19 12 12 19"></polyline>
    </g>
  </Svg>
);

const Svg = styled.svg`
  width: ${({ size }) => size}px;
  height: ${({ size }) => size}px;
  flex-shrink: 0;
  flex-growth: 0;
`;
