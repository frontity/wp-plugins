import styled from "@emotion/styled";

export default styled.a`
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

  border: ${({ primary }) =>
    primary ? "none" : "solid 2px rgba(32, 56, 197, 0.4)"};

  color: ${({ primary }) => (primary ? "#ffffff" : "##1f38c5")};
  font-family: Poppins, sans-serif;
  font-size: 12px;
  font-weight: 600;
  font-stretch: normal;
  font-style: normal;
  line-height: 1.33;
  letter-spacing: 1.2px;
  text-transform: uppercase;
`;
