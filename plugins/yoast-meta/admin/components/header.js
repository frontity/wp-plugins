import React from "react";
import styled from "@emotion/styled";
import Button from "./button";

const Header = () => {
  return (
    <HeaderContainer>
      <HeaderTitle>
        REST API - Head Tags Plugin by <FrontityLogo />
      </HeaderTitle>
      <HeaderButtons>
        <Button>Ask the community</Button>
        <Button primary icon>
          Documentation
        </Button>
      </HeaderButtons>
    </HeaderContainer>
  );
};

export default Header;

const HeaderContainer = styled.div`
  height: 64px;
  background-color: #ffffff;
  box-shadow: 0 1px 4px 0 rgba(31, 56, 197, 0.12);
  display: flex;
  flex-direction: row;
  justify-content: space-between;
  align-items: center;
  padding: 0 32px;
`;

const HeaderTitle = styled.h1``;

const HeaderButtons = styled.div`
  display: flex;
  flex-direction: row;
  justify-content: space-between;

  & > * {
    margin-left: 16px;
  }
`;

const FrontityLogo = styled.div``;
