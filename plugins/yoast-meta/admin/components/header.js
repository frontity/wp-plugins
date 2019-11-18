import React from "react";
import styled from "@emotion/styled";
import Button from "./button";
import FrontityIcon from "./icons/frontity";
import FrontityLogo from "./frontity-logo";

const Header = () => {
  return (
    <HeaderContainer>
      <HeaderTitle>
        REST API - Head Tags Plugin by{" "}
        <FrontityLogoContainer>
          <FrontityLogo color="#1f38c5" />
        </FrontityLogoContainer>
      </HeaderTitle>
      <HeaderButtons>
        <Button href="https://community.frontity.org" target="_blank">
          Ask the community
        </Button>
        <Button
          primary
          icon={<FrontityIcon />}
          href="https://docs.frontity.org"
          target="_blank"
        >
          Documentation
        </Button>
      </HeaderButtons>
    </HeaderContainer>
  );
};

export default Header;

const HeaderContainer = styled.div`
  background-color: #ffffff;
  box-sizing: border-box;
  box-shadow: 0 1px 4px 0 rgba(31, 56, 197, 0.12);
  display: flex;
  flex-direction: row;
  flex-wrap: wrap;
  justify-content: space-between;
  align-items: center;
  padding: 16px 32px;
`;

const HeaderTitle = styled.h2``;

const HeaderButtons = styled.div`
  display: flex;
  flex-direction: row;
  justify-content: space-between;

  & > * {
    margin-left: 16px;
  }
`;

const FrontityLogoContainer = styled.span`
  svg {
    height: 0.8em;
    margin-left: 8px;
    overflow: visible;
    vertical-align: baseline;
  }
`;
