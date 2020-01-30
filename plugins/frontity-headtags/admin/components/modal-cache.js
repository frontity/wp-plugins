import React from "react";
import connect from "@frontity/connect";
import styled from "@emotion/styled";
import Card from "./card";
import Button from "./button";

const ModalCache = ({ state, actions }) => {
  const { isWaitingConfirmation, isConfirmed } = state.headtags.cacheModal;
  const { clearCache, closeCacheModal } = actions.headtags;
  return (
    <>
      {isWaitingConfirmation && (
        <ModalContainer>
          <StyledCard>
            <ModalTitle>
              Are you sure you want to invalidate all cached items?
            </ModalTitle>
            <InputContainer>
              <Button primary onClick={closeCacheModal}>
                no
              </Button>
              <Button onClick={clearCache}>yes, invalidate</Button>
            </InputContainer>
          </StyledCard>
        </ModalContainer>
      )}
      {isConfirmed && (
        <ModalContainer>
          <StyledCard>
            <ModalTitle>Cache has been invalidated</ModalTitle>
            <InputContainer>
              <Button primary onClick={closeCacheModal}>
                close
              </Button>
            </InputContainer>
          </StyledCard>
        </ModalContainer>
      )}
    </>
  );
};

export default connect(ModalCache);

const ModalContainer = styled.div`
  position: absolute;
  top: 0;
  bottom: 0;
  left: 0;
  right: 0;
  display: flex;
  justify-content: center;
  align-items: center;
  background-color: rgba(0, 0, 0, 0.5);
  padding: 16px;
  border-radius: 4px;
`;

const StyledCard = styled(Card)`
  display: flex;
  flex-direction: column;
  align-items: center;
`;

const ModalTitle = styled.strong`
  margin-bottom: 16px;
  text-align: center;
`;

const InputContainer = styled.div`
  display: flex;

  & > *:not(:last-child) {
    margin-right: 16px;
  }
`;
