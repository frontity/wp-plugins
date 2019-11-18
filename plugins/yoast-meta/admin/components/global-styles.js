import React from "react";
import { Global, css } from "@emotion/core";

export default () => <Global styles={globalStyles} />;

const globalStyles = css`
  /* Poppins font */
  @import url("https://fonts.googleapis.com/css?family=Poppins:400,600&display=swap");

  #root {
    font-family: Poppins, sans-serif;
    font-size: 16px;
    font-weight: normal;
    font-stretch: normal;
    font-style: normal;
    line-height: 1.5;
    letter-spacing: normal;
    color: rgba(12, 17, 43, 0.8);

    small {
      font-size: 12px;
      line-height: 1.33;
      color: #24282e;
    }

    h1,
    h2,
    h3,
    h4 {
      font-weight: 600;
      color: #0c112b;
      margin: 0;
    }

    h1 {
      font-size: 32px;
      line-height: 40px;
    }
    h2 {
      font-size: 24px;
      line-height: 32px;
    }
    h3 {
      font-size: 20px;
      line-height: 24px;
    }
    h4 {
      font-size: 14px;
      line-height: 20px;
    }
  }
`;
