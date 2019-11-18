import React from "react";
import styled from "@emotion/styled";
import TinyCard from "./tiny-card";
import Link from "./link";

const Footer = () => {
  return (
    <FooterContainer>
      <div>
        <TinyCard>
          Any problem or questions? Join our community forum and let us know,
          we'll be happy to help!
        </TinyCard>
        <Link>Ask the community</Link>
      </div>
      <hr />
      <TinyCard>
        Frontity is an open source framework for building headless WordPress
        sites with ReactJS. If you like the project, you can show your support
        by leaving a positive review here or starring it on GitHub.
      </TinyCard>
      <div>
        <Link>Follow Frontity</Link>
        <Link>Get involved on GitHub</Link>
        <Link>Get updates about Frontity</Link>
      </div>
    </FooterContainer>
  );
};

export default Footer;

const FooterContainer = styled.footer`
  margin: auto;
  max-width: 968px;
`;

const Bar = styled.hr``;
