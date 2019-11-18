import React from "react";
import styled from "@emotion/styled";
import TinyCard from "./tiny-card";
import Link from "./link";
import GitHub from "./icons/github";
import Frontity from "./icons/frontity";
import Twitter from "./icons/twitter";

const Footer = () => {
  return (
    <FooterContainer>
      <FooterTop>
        <TinyCard>
          Any problem or questions? Join our community forum and let us know,
          we'll be happy to help!
        </TinyCard>
        <Space size={44} />
        <Link
          icon={<Frontity />}
          href="https://community.frontity.org"
          target="_blank"
        >
          Ask the community
        </Link>
      </FooterTop>
      <HorizontalBar />
      <TinyCard>
        Frontity is an open source framework for building headless WordPress
        sites with ReactJS. If you like the project, you can show your support
        by leaving a positive review here or starring it on GitHub.
      </TinyCard>
      <FooterBottom>
        <Link
          icon={<Twitter />}
          href="https://twitter.com/frontity"
          target="_blank"
        >
          Follow Frontity
        </Link>
        <Space size={54} />
        <Link
          icon={<GitHub />}
          href="https://github.com/frontity"
          target="_blank"
        >
          Get involved on GitHub
        </Link>
        <Space size={54} />
        <Link
          icon={<Frontity />}
          href="https://frontity.org/#newsletter"
          target="_blank"
        >
          Get updates about Frontity
        </Link>
      </FooterBottom>
    </FooterContainer>
  );
};

export default Footer;

const FooterContainer = styled.footer`
  margin: auto;
  max-width: 968px;
`;

const Space = styled.div`
  width: ${({ size }) => size || 0}px;
  height: ${({ size }) => size || 0}px;
`;

const FooterTop = styled.div`
  display: flex;
  flex-direction: row;
  align-items: baseline;
`;

const FooterBottom = styled.div`
  display: flex;
  flex-direction: row;
`;

const HorizontalBar = styled.hr``;
