import styled from "@emotion/styled";

export default styled.div`
  margin: ${({ margin }) => margin};
  padding: 32px;
  background-color: #ffffff;
  box-sizing: border-box;
  box-shadow: 0 1px 4px 0 rgba(31, 56, 197, 0.12);
  border-radius: 4px;
  font-size: 16px;
  line-height: 24px;

  display: flex;

  @media (min-width: 600px) {
    flex-direction: row;
    align-items: center;
    & > *:not(:last-child) {
      margin-right: 16px;
    }
  }

  @media (max-width: 599px) {
    flex-direction: column;
    & > *:not(:last-child) {
      margin-bottom: 16px;
    }
  }
`;
