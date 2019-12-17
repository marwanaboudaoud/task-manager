import React, { Component } from "react";
import { Row, Container } from "react-bootstrap";
import userCheck from "../../assets/user-check.svg";
import styles from "./styles.module.scss";

class MyTask extends Component {
  state = {};
  render() {
    return (
      <div>
        <Container>
          <Row>
            <img src={userCheck} alt="" className={styles.userCheck} />
            <p className={styles.p}>Mijn Taken</p>
          </Row>
        </Container>
      </div>
    );
  }
}

export default MyTask;
