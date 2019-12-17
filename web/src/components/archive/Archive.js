import React, { Component } from "react";
import { Row, Container } from "react-bootstrap";
import archive from "../../assets/archive.svg";
import styles from "./styles.module.scss";

class Archive extends Component {
  state = {};
  render() {
    return (
      <div>
        <Container>
          <Row>
            <img src={archive} alt="" className={styles.archive} />
            <p className={styles.p}>Archief</p>
          </Row>
        </Container>
      </div>
    );
  }
}

export default Archive;
