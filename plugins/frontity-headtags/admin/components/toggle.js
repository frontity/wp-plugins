import React from "react";
import styled from "@emotion/styled";
import CheckIcon from "./icons/check";
import CloseIcon from "./icons/close";

const Toggle = ({ checked, onClick }) => {
  return (
    <ToggleContainer
      role="checkbox"
      aria-checked={checked}
      tabIndex="0"
      onClick={onClick}
      onKeyPress={onClick}
    >
      <Handle isMoved={checked} />
      <CheckIcon color="white" size={16} />
      <CloseIcon color="white" size={12} />
    </ToggleContainer>
  );
};

export default Toggle;

const ToggleContainer = styled.div`
  position: relative;
  width: 60px;
  height: 32px;
  box-sizing: border-box;
  border-radius: 18px;
  background-color: ${({ "aria-checked": checked }) =>
    checked ? "#7dd72d" : "#d0d0d0"};
  transition: background-color 0.2s ease-out;
  display: flex;
  flex-direction: row;
  justify-content: space-between;
  align-items: center;
  padding: 0 12px;
  cursor: pointer;

  &:focus {
    box-shadow: 0 0 0 1px #5b9dd9, 0 0 2px 1px rgba(30, 140, 190, 0.8);
    outline: 1px solid transparent;
  }
`;

const Handle = styled.div`
  position: absolute;
  top: 4px;
  left: 4px;
  width: 24px;
  height: 24px;
  border-radius: 18px;
  border: solid 1px rgba(12, 17, 43, 0.08);
  box-sizing: border-box;
  box-shadow: 0 1px 4px 0 rgba(12, 17, 43, 0.12);
  background-color: #ffffff;

  transform: ${({ isMoved }) => (isMoved ? "translateX(28px)" : "none")};
  transition: transform 0.2s ease-in-out;
`;
