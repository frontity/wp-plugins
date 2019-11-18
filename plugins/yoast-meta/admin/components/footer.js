import React from "react";
import styled from "@emotion/styled";
import TinyCard from "./tiny-card";
import Link from "./link";
import GitHub from "./icons/github";
import Frontity from "./icons/frontity";
import Twitter from "./icons/twitter";
import Info from "./icons/info";
import Heart from "./icons/heart";

const Footer = () => {
  return (
    <FooterContainer>
      <Row gap={44}>
        <TinyCard>
          <Info color="#b1b3bb" size={16} />
          Any problem or questions? Join our community forum and let us know,
          we'll be happy to help!
        </TinyCard>
        <Link
          icon={<Frontity />}
          href="https://community.frontity.org"
          target="_blank"
        >
          Ask the community
        </Link>
      </Row>
      <Separator />
      <TinyCard margin="35px 0">
        <Heart color="#ea5a35" size={16} />
        Frontity is an open source framework for building headless WordPress
        sites with ReactJS. If you like the project, you can show your support
        by leaving a positive review here or starring it on GitHub.
      </TinyCard>
      <Row gap={54}>
        <Link
          icon={<Twitter />}
          href="https://twitter.com/frontity"
          target="_blank"
        >
          Follow Frontity
        </Link>
        <Link
          icon={<GitHub />}
          href="https://github.com/frontity"
          target="_blank"
        >
          Get involved on GitHub
        </Link>
        <Link
          icon={<Frontity />}
          href="https://frontity.org/#newsletter"
          target="_blank"
        >
          Get updates about Frontity
        </Link>
      </Row>
    </FooterContainer>
  );
};

export default Footer;

const FooterContainer = styled.footer`
  margin: auto;
  max-width: 968px;
  padding: 0 16px;
`;

const Row = styled.div`
  display: flex;

  @media only screen and (min-width: 968px) {
    flex-direction: row;
    align-items: baseline;
    & > * {
      margin-right: ${({ gap }) => gap}px;
    }
    & > *:last-child {
      margin-right: 0;
    }
  }

  @media only screen and (max-width: 967px) {
    flex-direction: column;
    align-items: stretch;
    & > * {
      margin-bottom: ${({ gap }) => gap / 2}px;
    }
    & > *:last-child {
      margin-bottom: 0;
  }
`;

const Separator = styled.div`
  margin: 45px 0;
  height: 4px;
  opacity: 0.08;
  background-color: #1f38c5;
`;
