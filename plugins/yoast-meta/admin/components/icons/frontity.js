import React from "react";
import styled from "@emotion/styled";

export default ({ color, size }) => (
  <Svg fill={color || "currentColor"} size={size} viewBox="0 0 698 558">
    <path d="M93.292 558L379 273.188 93.292 0 0 93l189.5 180.188L0 462.094z" />
    <path d="M412.292 558L698 273.188 412.292 0 319 93l189.5 180.188L319 462.094z" />
  </Svg>
);

const Svg = styled.svg`
  width: ${({ size }) => size}px;
  height: ${({ size }) => size}px;
  flex-shrink: 0;
  flex-growth: 0;
`;
