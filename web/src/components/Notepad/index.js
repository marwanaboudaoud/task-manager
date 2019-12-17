import React from "react";
import styles from "./styles.module.scss";
import { ButtonToolbar, DropdownButton } from "react-bootstrap";

class Notepad extends React.Component {
  render() {
    return (
      <div>
        <ButtonToolbar>
          <DropdownButton
            size="md"
            className={styles.dropleft}
            drop={"up"}
            variant="Secondary"
            title={"Kladbok"}
          >
            <div>
              <textarea className={styles.textarea}></textarea>
            </div>
          </DropdownButton>
        </ButtonToolbar>
      </div>
    );
  }
}

export default Notepad;

// <DropdownButton
// size="md"
// // className={styles.dropleft}
// drop={"dwon"}
// variant="Secondary"
// title={"Kladbok"}
// ></DropdownButton>
