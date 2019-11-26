import React from "react";
import styled from "@emotion/styled";
import TriangleIcon from "./icons/triangle";

const Dropdown = ({ margin, title, children }) => {
  const [isOpen, setOpen] = React.useState(true);
  const toggle = () => setOpen(!isOpen);

  return (
    <DropdownContainer margin={margin}>
      <DropdownHeader onClick={toggle}>
        <h2>{title}</h2>
        <TriangleIcon size={24} pointingDown={!isOpen} />
      </DropdownHeader>
      {isOpen && <DropdownContent>{children}</DropdownContent>}
    </DropdownContainer>
  );
};

export default Dropdown;

const DropdownContainer = styled.div`
  margin: ${({ margin }) => margin || 0};
  background-color: #ffffff;
  box-sizing: border-box;
  box-shadow: 0 1px 4px 0 rgba(31, 56, 197, 0.12),
    0 8px 12px 0 rgba(31, 56, 197, 0.12);
  border-radius: 4px;
  overflow: hidden;
`;

const DropdownHeader = styled.div`
  min-height: 80px;
  display: flex;
  justify-content: space-between;
  align-items: center;
  background-color: #f6f9fa;
  padding: 0 32px;
  box-sizing: border-box;
`;

const DropdownContent = styled.div`
  padding: 32px;
`;
